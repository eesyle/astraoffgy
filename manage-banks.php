<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management</title>
    <link rel="stylesheet" href="styleee.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
       
            <?php include 'adminSideBar.php'; ?>
        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Manage Banks</h1>
                <a class="logout-btn" href="dash.php">Logout</a>
            </header>

            <!-- Manage Banks Content -->
            <section class="content-section">
                <h2>Bank Management Section</h2>
                <ul class="bank-list">
                    <li>
                        <a href="cufat_index" >EDIT AFCU Bank</a> 
                    </li>
                    <li>
                         <a href="chris_index" >EDIT cibc Bank</a> 
                    </li>
                    <li><a href="strandsa_index">EDIT Santander Bank</a></li>
                    <li><a href="ybb_index">EDIT BARCLAYS Bank</a></li>
                    <li><a href="amp_index">EDIT SURNCORP Bank</a></li>
                    <li><a href="cpt1_index">EDIT CAPITAL ONE Bank</a></li>
                    <li><a href="rg_index">EDIT REGION Bank</a></li>
                    <li><a href="oab_index">EDIT BANK OF AMERICA Bank</a></li>
                    <li><a href="leo_index">EDIT Cash app bank</a></li>
                    <li><a href="sim_index">EDIT Chase Bank</a></li>
                    <li><a href="niche_index">EDIT Chime Bank</a></li>
                    <li><a href="nab_index">EDIT National Bank of Australia</a></li>
                    <li><a href="msa_index">EDIT USAA Bank</a></li>
                    <li><a href="acii_index">EDIT Citi Bank</a></li>
                    <li><a href="bouchc_index">EDIT HSBC Bank</a></li>
                    <li><a href="pop_index">EDIT Citizen Bank</a></li>
                    <li><a href="cud_index">EDIT DCU Bank</a></li>
                    <li><a href="ieei_index">EDIT Huntington Bank</a></li>
                    <li><a href="eat_index">EDIT M&T Bank</a></li>
                    <li><a href="ly_index">EDIT PayPal Bank</a></li>
                    <li><a href="atew_index">EDIT T&D Bank</a></li>
                    <li><a href="gw_index.php">EDIT Wells Fargo Bank</a></li>
                    <li><a href="dw_index">EDIT Woodforest Bank</a></li>
                    <!-- Missing banks added -->
                    <li><a href="navyfederal_index">EDIT Navy Federal Credit Union</a></li>
                    <li><a href="keybank_index">EDIT KeyBank</a></li>
                    <li><a href="pnc_index">EDIT PNC Bank</a></li>
                    <li><a href="truist_index">EDIT Truist Bank</a></li>
                    <li><a href="boq_index">EDIT Bank of Queensland</a></li>
                    <li><a href="bankaustralia_index">EDIT Bank Australia</a></li>
                </ul>
            </section>
        </div>
    </div>
</body>
</html>
