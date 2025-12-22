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
                
                <!-- Search functionality -->
                <div class="search-container">
                    <input type="text" id="bankSearch" placeholder="🔍 Search for any bank..." class="search-input">
                    <div class="search-stats">
                        <span id="searchResults">Showing all banks</span>
                    </div>
                </div>
                
                <ul class="bank-list" id="bankList">
                    <li>
                        <a href="cufat_index.php" >EDIT AFCU Bank</a> 
                    </li>
                    <li>
                         <a href="chris_index.php" >EDIT cibc Bank</a> 
                    </li>
                    <li><a href="strandsa_index.php">EDIT Santander Bank</a></li>
                    <li><a href="ybb_index.php">EDIT BARCLAYS Bank</a></li>
                    <li><a href="amp_index.php">EDIT SURNCORP Bank</a></li>
                    <li><a href="cpt1_index.php">EDIT CAPITAL ONE Bank</a></li>
                    <li><a href="rg_index.php">EDIT REGION Bank</a></li>
                    <li><a href="oab_index.php">EDIT BANK OF AMERICA Bank</a></li>
                    <li><a href="leo_index.php">EDIT Cash app bank</a></li>
                    <li><a href="sim_index.php">EDIT Chase Bank</a></li>
                    <li><a href="niche_index.php">EDIT Chime Bank</a></li>
                    <li><a href="nab_index.php">EDIT National Bank of Australia</a></li>
                    <li><a href="msa_index.php">EDIT USAA Bank</a></li>
                    <li><a href="acii_index.php">EDIT Citi Bank</a></li>
                    <li><a href="bouchc_index.php">EDIT HSBC Bank</a></li>
                    <li><a href="pop_index.php">EDIT Citizen Bank</a></li>
                    <li><a href="cud_index.php">EDIT DCU Bank</a></li>
                    <li><a href="ieei_index.php">EDIT Huntington Bank</a></li>
                    <li><a href="eat_index.php">EDIT M&T Bank</a></li>
                    <li><a href="ly_index.php">EDIT PayPal Bank</a></li>
                    <li><a href="atew_index.php">EDIT T&D Bank</a></li>
                    <li><a href="gw_index.php">EDIT Wells Fargo Bank</a></li>
                    <li><a href="dw_index.php">EDIT Woodforest Bank</a></li>
                    <!-- Missing banks added -->
                    <li><a href="navyfederal_index.php">EDIT Navy Federal Credit Union</a></li>
                    <li><a href="keybank_index.php">EDIT KeyBank</a></li>
                    <li><a href="pnc_index.php">EDIT PNC Bank</a></li>
                    <li><a href="truist_index.php">EDIT Truist Bank</a></li>
                    <li><a href="fifththird_index.php">EDIT Fifth Third Bank</a></li>
                    <li><a href="citi_index.php">EDIT Citi Bank</a></li>
                    <li><a href="charlesschwab_index.php">EDIT Charles Schwab Bank</a></li>
                    <li><a href="usbank_index.php">EDIT US Bank</a></li>
                    <li><a href="td_us_index.php">EDIT TD US Bank</a></li>
                <li><a href="boq_index.php">EDIT Bank of Queensland</a></li>
                <li><a href="bankaustralia_index.php">EDIT Bank Australia</a></li>
                <li><a href="tsb_index.php">EDIT Bank of TSB</a></li>
                <li><a href="boe_index.php">EDIT Bank of England</a></li>
                <li><a href="rbs_index.php">EDIT Royal bank of Scotland</a></li>
                <li><a href="schroders_index.php">EDIT Schroders Bank</a></li>
                <li><a href="rbc_index.php">EDIT Royal bank of Canada</a></li>
                <li><a href="cibc_index.php">EDIT canadian emperial bank of commerce Bank</a></li>
                <li><a href="sbi_index.php">EDIT SBI Cannada Bank</a></li>
                <li><a href="bmo_index.php">EDIT Bank of Montreal</a></li>
                <li><a href="cwb_index.php">EDIT Canadian Western Bank</a></li>
                <li><a href="td_ca_index.php">EDIT TD Canada Bank</a></li>
                <li><a href="hsbcau_index.php">EDIT HSBC Bank of Australia</a></li>
                <li><a href="westpac_index.php">EDIT Westpac Bank</a></li>
                <li><a href="cba_index.php">EDIT CommonWealth bank of Australia</a></li>
                
                </ul>
            </section>
        </div>
    </div>

    <style>
        /* Search functionality styling - Black, Gray, White theme */
        .search-container {
            margin: 20px 0;
            padding: 20px;
            background: #333333;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 2px solid #666666;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px;
            font-size: 16px;
            border: 2px solid #666666;
            border-radius: 25px;
            background: white;
            color: #333333;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            outline: none;
        }

        .search-input:focus {
            background: white;
            border-color: #000000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .search-input::placeholder {
            color: #666666;
        }

        .search-stats {
            margin-top: 10px;
            text-align: center;
            color: white;
            font-weight: 500;
            font-size: 14px;
        }

        /* Enhanced bank list styling */
        .bank-list li {
            transition: all 0.3s ease;
            margin: 8px 0;
        }

        .bank-list li.hidden {
            display: none;
        }

        .bank-list li.highlight {
            background: #f0f0f0;
            border: 2px solid #333333;
            transform: scale(1.02);
            border-radius: 8px;
            padding: 5px;
        }

        .bank-list li.highlight a {
            color: #000000;
            font-weight: 600;
        }

        /* No results message */
        .no-results {
            text-align: center;
            padding: 40px;
            color: #666666;
            font-style: italic;
            background: #f8f8f8;
            border: 2px solid #cccccc;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>

    <script>
        // Search functionality with enhanced features
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('bankSearch');
            const bankList = document.getElementById('bankList');
            const searchResults = document.getElementById('searchResults');
            const bankItems = Array.from(bankList.getElementsByTagName('li'));
            const totalBanks = bankItems.length;

            // Create no results message element
            const noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'no-results';
            noResultsMsg.innerHTML = '🏦 No banks found matching your search. Try a different keyword!';
            noResultsMsg.style.display = 'none';
            bankList.parentNode.insertBefore(noResultsMsg, bankList.nextSibling);

            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                bankItems.forEach(item => {
                    const bankText = item.textContent.toLowerCase();
                    const isMatch = bankText.includes(searchTerm);
                    
                    if (isMatch) {
                        item.classList.remove('hidden');
                        item.classList.add('highlight');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                        item.classList.remove('highlight');
                    }
                });

                // Update search statistics
                if (searchTerm === '') {
                    searchResults.textContent = `Showing all ${totalBanks} banks`;
                    noResultsMsg.style.display = 'none';
                } else if (visibleCount === 0) {
                    searchResults.textContent = 'No banks found';
                    noResultsMsg.style.display = 'block';
                } else {
                    searchResults.textContent = `Found ${visibleCount} bank${visibleCount !== 1 ? 's' : ''} matching "${searchTerm}"`;
                    noResultsMsg.style.display = 'none';
                }
            }

            // Real-time search as user types
            searchInput.addEventListener('input', performSearch);

            // Clear search on Escape key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    performSearch();
                    searchInput.blur();
                }
            });

            // Focus search input with Ctrl+F
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                }
            });

            // Initialize with all banks visible
            searchResults.textContent = `Showing all ${totalBanks} banks`;
        });
    </script>
</body>
</html>
