#!/usr/bin/env nodejs
// run chrome first with command
// google-chrome-stable --remote-debugging-port=9222 --disable-translate --disable-extensions --disable-background-networking --safebrowsing-disable-auto-update --disable-sync --metrics-recording-only --disable-default-apps --no-first-run --disable-setuid-sandbox --window-size=1280x1012 --disable-gpu --hide-scrollbars --headless --blink-settings=imagesEnabled=false about:blank &

const http = require('http');
const url = require('url');
const CDP = require('chrome-remote-interface');

const server = http.createServer(function (req, res) {
  const urlParts = url.parse(req.url, true);
  if (req.url === '/health') {
      res.writeHead(200, {'Content-Type': 'text/html'});
      res.end('health check');
  } else {
      if (urlParts.query.secret === 'supersecretpassword' && urlParts.query.url !== undefined) {
          //console.log('Starting CDP');
          CDP((client) => {
              const {Network, Page, Runtime} = client;
              let statusCode = false;
              Network.responseReceived((params) => {
                  if (statusCode === false && params.type === 'Document') {
                      statusCode = params.response.status;
                  }
              });
              Page.loadEventFired(() => {
                  //console.log('LoadEvent fired');
                  setTimeout(function () {
                      Runtime.evaluate({
                          expression: 'document.documentElement.outerHTML'
                      }).then((result) => {
                          //console.log('Sending HTML');
                          client.close();
                          res.writeHead(statusCode, {'Content-Type': 'text/html', 'X-Chrome': 'OK'});
                          res.end(result.result.value);
                      }).catch((err) => {
                          res.writeHead(500, {'Content-Type': 'text/html', 'X-Chrome': 'evaluate error'});
                          client.close();
                          res.end(err.toString());
                      });
                  }, 5000);
              });
              // enable events then start!
              Promise.all([
                  Network.enable(),
                  Page.enable(),
                  Network.setCacheDisabled({cacheDisabled: true})
              ]).then(() => {
                  //console.log('Navigating URL');
                  return Page.navigate({url: urlParts.query.url});
              }).catch((err) => {
                  client.close();
                  res.writeHead(500, {'Content-Type': 'text/html', 'X-Chrome': 'init error'});
                  res.end(err.toString());
              });
          }).on('error', (err) => {
              // cannot connect to the remote endpoint
              const exec = require('child_process').exec;

              function execute(command, callback) {
                  exec(command, function (error, stdout, stderr) {
                      callback(stdout);
                  });
              }

              execute("ps ax | grep remote-debug", function (data) {
                  if (data.match(/remote-debug/g).length < 3) {
                      // relaunch chrome
                      const spawn = require('child_process').spawn;
                      spawn('google-chrome-stable', [
                          '--remote-debugging-port=9222',
                          '--disable-translate',
                          '--disable-extensions',
                          '--disable-background-networking',
                          '--safebrowsing-disable-auto-update',
                          '--disable-sync',
                          '--metrics-recording-only',
                          '--disable-default-apps',
                          '--no-first-run',
                          '--disable-setuid-sandbox',
                          '--window-size=1280x1012',
                          '--disable-gpu',
                          '--hide-scrollbars',
                          '--blink-settings=imagesEnabled=false',
                          '--headless',
                          'about:blank'
                      ], {
                          stdio: 'ignore', // piping all stdio to /dev/null
                          detached: true
                      }).unref();
                  }
              });
              res.writeHead(500, {'Content-Type': 'text/html', 'X-Chrome': 'restart'});
              res.end(err.toString());
          });
      } else {
          res.writeHead(403, {'Content-Type': 'text/html', 'X-Chrome': 'access denied'});
          res.end('access denied');
      }
  }
}).listen(8080, 'localhost');

server.timeout = 30000;
server.keepAliveTimeout = 0;
console.log('Server running at http://localhost:8080/');