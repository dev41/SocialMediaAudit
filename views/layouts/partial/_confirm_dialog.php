<script type="text/template" class="js-confirm-dialog-template">
    <div class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close js-btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <strong>{title}</strong>
                    </h4>
                </div>

                <div class="modal-body">
                    {content}
                </div>

                <div class="modal-footer" style="padding-top: 0; border-top: none;">
                    <div class="submit-loader-box">
                        <button type="button" class="btn btn-danger js-btn-ok">
                            {labelOk}
                        </button>
                        <button type="button" class="btn btn--primary js-btn-close" data-dismiss="modal">
                            {labelClose}
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</script>