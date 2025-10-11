<div class="modal fade" id="reviewModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="code-review.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Leave a review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="amount1" class="form-control w-100 mb-3" placeholder="Enter your username" name="username" required />
                    <input type="text" id="amount1" class="form-control w-100 mb-3" placeholder="Enter your email" name="email" required />
                    <textarea id="commentInput" class="form-control w-100 mb-3" placeholder="Write your review..." name="review" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" name="submit-review">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
