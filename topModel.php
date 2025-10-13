<style>
  /* Futuristic glass + neon styling scoped to TopUp modal */
  #topUpAccountModal .modal-dialog { max-width: 560px; }
  #topUpAccountModal .modal-content {
    background: linear-gradient(180deg, rgba(22,24,35,0.85) 0%, rgba(16,18,28,0.9) 100%);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(120, 130, 255, 0.25);
    box-shadow: 0 10px 30px rgba(120, 130, 255, 0.25), inset 0 0 30px rgba(0,0,0,0.2);
    border-radius: 16px;
    overflow: hidden;
  }
  #topUpAccountModal .modal-header {
    background: linear-gradient(90deg, rgba(88,95,255,0.2), rgba(0,212,255,0.15));
    border-bottom: 1px solid rgba(120, 130, 255, 0.2);
  }
  #topUpAccountModal .modal-title {
    color: #e9e9ff;
    letter-spacing: 0.3px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  #topUpAccountModal .modal-title .bi,
  #topUpAccountModal .modal-title .fa {
    color: #8ae0ff;
    text-shadow: 0 0 8px rgba(0,212,255,0.7);
  }
  #topUpAccountModal .modal-body { color: #d9dcff; }
  #topUpAccountModal label.form-label { color: #bfc5ff; }
  #topUpAccountModal input.form-control {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(120,130,255,0.25);
    color: #e9ebff;
    border-radius: 12px;
  }
  #topUpAccountModal input.form-control::placeholder { color: #a5acff; }
  #topUpAccountModal .btn-primary {
    background: linear-gradient(135deg, #5b62ff 0%, #00d4ff 100%);
    border: none;
    box-shadow: 0 6px 20px rgba(91, 98, 255, 0.35);
  }
  #topUpAccountModal .btn-secondary {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(120,130,255,0.25);
    color: #cbd0ff;
  }
  #topUpAccountModal .modal-footer { border-top: 1px solid rgba(120,130,255,0.2); }
</style>

<div class="modal fade" id="topUpAccountModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="post" action="codeTop.php">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">
            <i class="fa fa-bolt"></i>
            Top Up your account
          </h5>
          <!-- Bootstrap 5 close -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <!-- Bootstrap 4 fallback close -->
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity:0.6;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="amount1" class="form-label d-block">Enter Amount (in USD)</label>
          <input type="text" id="amount1" class="form-control w-100 mb-3" placeholder="Enter how much you want to top up" name="price" required />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm" name="init-top-up">Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>