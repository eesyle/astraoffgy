<div class="modal fade" id="updateUserPassword">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="resetCode.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="password" id="passInput1" class="form-control w-100 mb-3" placeholder="Enter New Password" name="newpass" required /><br>
                        <input type="password" id="passInput2" class="form-control w-100 mb-3" placeholder="Confirm New Password" name="confirmPass" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm btn-rounded" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-rounded" name="resetPassword">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>