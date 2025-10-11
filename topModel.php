<div class="modal fade" id="topUpAccountModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="codeTop.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Top Up your account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="amount1" class="form-label d-block">Enter Amount (in USD)</label>
                        <input type="text" id="amount1" class="form-control w-100 mb-3" placeholder="Enter how much you want to topup" name="price" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" name="init-top-up">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>