#!/usr/bin/env nodejs

const http = require('http');
const url = require('url');
const httpProxy = require('http-proxy');

const chromeServers = require('./lb-config');
let availableServers = chromeServers.servers;
let status = {};

const proxy = httpProxy.createProxyServer({});
proxy.on('error', function (err, req, res) {
  res.writeHead(500, {
    'Content-Type': 'text/html',
    'X-Chrome': 'LB proxy error'
  });
  res.end('Something went wrong with Load Balancer.');
});
proxy.on('proxyReq', function (proxyReq, req, res) {
    proxyReq.socket.on('connect', function() {
        console.log('Unset', this.remoteAddress);
        status[this.remoteAddress] = req.url;
    });
});
proxy.on('proxyRes', function (proxyRes, req, res) {
    console.log('Set  ', proxyRes.socket.remoteAddress);
    delete status[proxyRes.socket.remoteAddress];
    availableServers.push(proxyRes.connection.remoteAddress);
});

const server = http.createServer(async function (request, response) {
  const urlParts = url.parse(request.url, true);
  if (request.url === '/status') {
      response.writeHead(200, {'Content-Type': 'text/html'});
      response.end('<html><head><title>LB Status</title></head><body>Available servers: <strong>'+availableServers.length+'</strong><br />'+showAvailableServers()+'<br /><p>'+showServersStatus()+'</p><script type="text/javascript">setTimeout(function(){location.reload()}, 1000)</script></body></html>');
  } else {
      if (urlParts.query.secret === 'supersecretpassword' && urlParts.query.url !== undefined) {
          if (availableServers.length === 0) {
              response.writeHead(500, {'Content-Type': 'text/html', 'X-Chrome': 'LB empty'});
              response.end('no available servers');
          }
          request.myip = availableServers.shift();
          request.on('close', function () {
              console.log('Client request closed, set', this.myip);
              delete status[this.myip];
              availableServers.push(this.myip); // probably in rare situations could have duplicates because of this
          });
          proxy.web(request, response, {target: 'http://'+request.myip+':80'});
      } else {
          response.writeHead(403, {'Content-Type': 'text/html', 'X-Chrome': 'access denied'});
          response.end('access denied');
      }
  }
});
server.timeout = chromeServers.timeout; //60000; // light has 30, heavy has 55
server.keepAliveTimeout = 0;
server.listen(8080, 'localhost');
console.log('Server running at http://localhost:8080/');


function showAvailableServers() {
    let result = '';
    for (let i=0; i<availableServers.length; i++) {
        result += availableServers[i] + '<br />';
    }
    return result;
}

function showServersStatus() {
    let result = '';
    for (let ip in status) {
        result += ip + status[ip] + '<br />';
    }
    return result;
}
