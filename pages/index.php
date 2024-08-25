<?php
include 'db.php';

$is_logged_in = isset($_SESSION['user_id']);

$query = "SELECT ID, PRODUCTNAME, PRICING, IMGPRODUCT FROM cart_produk";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$conn->query("SET @id := 0");
$conn->query("UPDATE cart_produk SET ID = @id := (@id + 1)");
$conn->query("ALTER TABLE cart_produk AUTO_INCREMENT = 1");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../source/styles/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .zoom-animation{
            transform: scale(100%);
            transition: all ease-in-out 0.3s;
        }
        .zoom-animation:hover{
            transform: scale(102%);
            transition: all ease-in-out 0.3s;
        }

        .bg-gradient{
            background: rgb(203,175,132);
            background: linear-gradient(0deg, rgba(203,175,132,1) 0%, rgba(241,241,241,1) 100%);
        }

        .bg-gradient-radial{
            background: rgb(203,175,132);
            background: radial-gradient(circle, rgba(203,175,132,1) 0%, rgba(241,241,241,1) 100%);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="bg-[#E6E6E6] overflow-y-auto max-h-screen">
        <section id="HOME" class="px-20 pt-20 2xl:pt-32 h-screen">
            <div class="bgimg-100 bg-gray-400 md:h-64 2xl:h-[400px] flex items-end p-8 mb-8 rounded-md">
                <span class="text-[#503321] font-medium text-3xl font-sans tshadow-sm">Military.<br>Industrial.<br>Complex.</span>
            </div>
            <div class="flex gap-4">
                <div class="w-auto flex flex-col items-center justify-center space-y-2">
                    <span class="text-justify font-sans 2xl:text-2xl">Selamat datang di MIC, pemimpin dalam inovasi dan teknologi cetak 3D di Indonesia. Kami berdedikasi untuk menghadirkan solusi cetak 3D berkualitas tinggi yang dapat mengubah ide-ide kreative Anda menjadi kenyataan. Dengan menggunakan teknologi terbaru dan bahan berkualitas premium, kami menawarkan layanan cetak 3D yang cepat, presisi, dan terjangkau untuk berbagai kebutuhan, mulai dari prototipe produk, komponen industri, hingga karya seni dan desain.</span>
                    <button type="button" onclick="window.location.href='#SHOP';" class="bg-[#503321] zoom-animation hover:bg-[#19191B] tracking-wide py-1 px-8 rounded-full text-white font-bold 2xl:text-3xl ">SHOP NOW</button>
                </div>
                <img src="https://img.freepik.com/free-photo/manager-secretary-discussing-working-thumb-up-white-background_554837-713.jpg?t=st=1722355397~exp=1722358997~hmac=bf09682339ddf5803d6238acc028f57981f66b091ef01b3aed5110e14c62ea5d&w=826" class="card zoom-animation bg-gray-400 object-cover rounded-md w-[180px] h-[180px] 2xl:w-[300px] 2xl:h-[300px]">
                <img src="https://img.freepik.com/free-photo/millennial-group-young-businesspeople-asia-businessman-businesswoman-celebrate-giving-five-after-dealing-feeling-happy-signing-contract-agreement-meeting-room-small-modern-office_7861-2493.jpg?uid=R117730523&ga=GA1.1.1739804183.1722268117&semt=ais_hybrid" class="card zoom-animation bg-gray-400 object-cover rounded-md w-[180px] h-[180px] 2xl:w-[300px] 2xl:h-[300px]">
                <img src="https://img.freepik.com/free-photo/asian-businessmen-businesswomen-meeting-brainstorming-ideas-about-creative-web-design-planning-application-developing-template-layout-mobile-phone-project-working-together-small-office_7861-2558.jpg?uid=R117730523&ga=GA1.1.1739804183.1722268117&semt=ais_hybrid" class="card zoom-animation bg-gray-400 object-cover rounded-md w-[180px] h-[180px] 2xl:w-[300px] 2xl:h-[300px]">
            </div>
        </section>

        <section id="ABOUT" class="flex bg-gradient justify-center pt-20 items-center h-screen">
            <div class="flex px-32 py-20 space-x-24 space-y-12">
                <img src="https://img.freepik.com/free-photo/view-3d-eagle-with-nature-landscape_23-2150813485.jpg?uid=R117730523&ga=GA1.1.1739804183.1722268117" class="card shadow-lg zoom-animation bg-gray-400 rounded-[30px] object-cover object-center w-[400px] h-[480px] 2xl: w-[500px] 2xl:h-[680px]">
                <div class="space-y-4">
                    <h1 class="text-4xl 2xl:text-6xl font-bold">THE Military Industrial Complex</h1>
                    <p class="text-md leading-6 2xl:text-2xl text-justify">Selamat datang di MIC Military Industrial Complex, penyedia solusi cetak 3D. Kami berdedikasi untuk menghadirkan inovasi dan kualitas tinggi dalam setiap proyek cetak 3D yang kami kerjakan. Dengan teknologi mutakhir dan tim ahli yang berpengalaman. Kami siap membantu Anda mewujudkan ide-ide kreatif menjadi kenyataan dari prototipe hingga produksi massal, kami menawarkan layanan yang disesuaikan dengan kebutuhan Anda. Temukan keunggulan 3D printing bersama kami di MIC Military Industrial Complex!</p>
                </div>
            </div>
        </section>

        <section id="SHOP" class="h-screen">
            <div class="py-20 px-20">
                <div class="text-center px-32">
                    <h1 class="text-3xl 2xl:text-6xl font-bold italic">ONLINE SHOP</h1>
                    <p class="text-md 2xl:text-2xl">Menghadirkan berbagai produk cetak 3D berkualitas tinggi yang dirancang untuk memenuhi kebutuhan industri dan komersial. Dari komponen presisi hingga model prototipe, setiap produk kami dibuat dengan teknologi terkini untuk memastikan akurasi dan ketahanan. Jelajai berbagai solusi cetak 3D kami yang inovatif dan dapat diandalkan untuk semua proyek Anda.</p>
                </div>
                <div class=" w-full h-px max-w-6xl mx-auto my-2"
                    style="background-image: linear-gradient(90deg, rgba(149, 131, 198, 0) 1.46%, rgba(149, 131, 198, 0.6) 40.83%, rgba(149, 131, 198, 0.3) 65.57%, rgba(149, 131, 198, 0) 107.92%);">
                </div>
                <div class="relative">

                    <button onclick="scrollLeft()" id="scrollLeftBtn" class="absolute left-0 top-1/2 w-12 h-12 2xl:w-16 2xl:h-16 transform -translate-y-1/2 text-2xl 2xl:text-4xl p-2 rounded-full z-10 shadow-md">
                        <i class="fas fa-arrow-left"></i>
                    </button>

                    <div id="product-container" class="relative flex mx-16 gap-4 p-4 overflow-x-auto rounded-md">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="shadow-md w-64 2xl:w-[400px] p-3 bg-white rounded-lg text-center">
                            <?php
                            $imgData = base64_encode($row['IMGPRODUCT']);
                            $imgSrc = "data:image/jpeg;base64,{$imgData}";
                            ?>
                            <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($row['PRODUCTNAME']); ?>" class="h-48 2xl:h-64 w-full object-cover rounded-lg">
                            <h1 class="text-xl sm:text-2xl 2xl:text-4xl font-semibold p-3"><?php echo htmlspecialchars($row['PRODUCTNAME']); ?></h1>
                            <p class="text-sm sm:text-md md:text-lg xl:text-2xl font-medium px-3"><?php echo 'Rp' . number_format($row['PRICING'], 2, ',', '.'); ?></p>
                            <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                                <button type="button" class="bg-gray-500 2xl:text-3xl font-medium p-2 text-gray-100 rounded w-full mt-3 hover:bg-gray-600 add-to-cart" data-id="<?php echo $row['ID']; ?>" data-price="<?php echo $row['PRICING']; ?>" data-name="<?php echo htmlspecialchars($row['PRODUCTNAME']); ?>" data-img="<?php echo $imgData; ?>">Add to cart</button>
                            <?php else: ?>
                                <input type="button" class="bg-gray-500 2xl:text-3xl font-medium p-2 text-gray-100 rounded w-full mt-3 hover:bg-gray-600 add-to-cart" value="Add to cart" disabled>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                    </div>

                    <button onclick="scrollRight()" id="scrollRightBtn" class="z-10 absolute 2xl:w-16 2xl:h-16 right-0 top-1/2 w-12 h-12 transform -translate-y-1/2 text-2xl 2xl:text-4xl p-2 rounded-full z-10 shadow-md">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </section>

        <section id="CONTACT" class="min-h-screen">
            <div class="flex py-32 px-32 space-x-6 justify-center items-center">
                <div class="w-[50%]">
                    <h1 class="text-4xl 2xl:text-6xl font-bold mb-2">Custom 3D Print</h1>
                    <span class="italic 2xl:text-4xl font-medium">Please fill out the form below</span>
                    <p class="text-justify 2xl:text-2xl mb-6 mt-2">
                        Ingin mencetak model 3D khusus yang sesuai dengan kebutuhan spesifik Anda? MIC Military Industrial Complex
                        Menyediakan layanan kustomisasi cetak 3D untuk mewujudkan ide-ide Anda menjadi  kenyataan. Dengan teknologi 
                        canggih dan tim ahli yang berpengalaman, Kami siap membantu Anda dari tahap desain hingga produksi. Hubungi 
                        Kami untuk konsultasi dan biarkan Kami membantu Anda menciptakan solusi cetak 3D yang unik dan berkualitas tinggi.
                    </p>
                    <h3 class="font-bold text-xl 2xl:text-4xl">E-MAIL:</h3>
                    <span class="font-medium text-lg 2xl:text-2xl">hello@THE_MIC.com</span>
                </div>
                <div class="w-[50%] px-6 zoom-animation">
                    <h3 class="font-medium text-md 2xl:text-2xl text-center mb-6">PEMESANAN & KUSTOMISASI 3D PRINT</h3>
                    <form method="POST" action="order.php" class="p-4 mt-4 shadow-md"  enctype="multipart/form-data">
                    <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                    <input type="text" id="username" name="username" 
                                value="<?php echo htmlspecialchars($_SESSION['username']); ?>" 
                                readonly placeholder="<?php echo htmlspecialchars($_SESSION['username']); ?>" 
                                class="mb-2 border 2xl:text-2xl rounded-md block w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none" 
                                required>
                        <?php else: ?>
                            <!-- Menyembunyikan atau mengosongkan input jika tidak ada username di session -->
                            <input type="text" id="username" name="username"  
                                readonly placeholder="Username" 
                                class="mb-2 block 2xl:text-2xl w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none" 
                                disabled>
                        <?php endif; ?>

                        <!-- Mengecek apakah email ada di session -->
                        <?php if (isset($_SESSION['usermail']) && !empty($_SESSION['usermail'])): ?>
                            <input type="email" id="email" name="email" 
                                value="<?php echo htmlspecialchars($_SESSION['usermail']); ?>" 
                                readonly placeholder="<?php echo htmlspecialchars($_SESSION['usermail']); ?>" 
                                class="mb-2 block 2xl:text-2xl rounded-md w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none" 
                                required>
                        <?php else: ?>
                            <input type="email" id="email" name="email" 
                                readonly placeholder="Email" 
                                class="mb-2 block 2xl:text-2xl w-full block rounded-md  px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none" 
                                disabled>
                        <?php endif; ?>
                        <div class="flex space-x-2 cursor-pointer">
                            <div class="flex items-center w-full">
                                <label for="file" id="fileLabel" class="block 2xl:text-2xl rounded-md w-64 max-w-64 2xl:w-[400px] 2xl:max-w-[400px] px-3 py-2 bg-[#D4C3A9] text-gray-600 overflow-hidden font-medium cursor-pointer hover:bg-[#c0ae94] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c0ae94] transition-colors duration-200 ease-in-out">
                                    Upload File
                                </label>
                                <input type="file" accept=".zip, .dae, .fbx, .stl, .obj, .blend" multiple id="file" name="file[]" class="hidden" required>
                            </div>

                            <div class="relative inline-block text-left w-full">
                                <!-- Hidden input to hold the selected value -->
                                <input type="hidden" id="bahan3DPValue" name="bahanprint">

                                <!-- Label dropdown -->
                                <label onclick="toggleDropdown('bahan3DP')" id="selectedBahan3DP" class="inline-flex 2xl:text-2xl block rounded-md  justify-center w-full h-12 px-4 py-2 bg-[#D4C3A9] font-medium text-gray-600 outline-none text-wrap overflow-hidden" aria-expanded="true" aria-haspopup="true">
                                    Bahan 3D Print
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </label>

                                <!-- Dropdown menu -->
                                <div id="bahan3DP" class="hidden z-20 origin-top-right absolute right-0 mt-2 w-64 rounded-md outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                    <ul class="bg-white border border-[#D4C3A9] rounded-md cursor-pointer" role="none">
                                        <li onclick="selectBahan('Polylactic Acid (PLA)')" class="text-gray-800 block rounded-t-md font-medium px-4 py-2 text-sm 2xl:text-2xl hover:bg-[#9E8561] hover:text-white" role="menuitem" tabindex="-1">Polylactic Acid (PLA)</li>
                                        <li onclick="selectBahan('Acrylonitrile Butadiene Styrene (ABS)')" class="text-gray-800 block font-medium px-4 py-2 text-sm 2xl:text-2xl hover:bg-[#9E8561] hover:text-white" role="menuitem" tabindex="-1">Acrylonitrile Butadiene Styrene (ABS)</li>
                                        <li onclick="selectBahan('Plastic Polyvinyl Alcohol (PVA)')" class="text-gray-800 block rounded-b-md font-medium px-4 py-2 text-sm 2xl:text-2xl hover:bg-[#9E8561] hover:text-white" role="menuitem" tabindex="-1">Plastic Polyvinyl Alcohol (PVA)</li>
                                    </ul>
                                </div>
                            </div>
                    
                        </div>

                        <div class="flex w-full mt-2 space-x-2">
                            <input type="number" id="panjang" name="panjang" placeholder="panjang" class="mb-2 2xl:text-2xl block rounded-md block w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none " required>
                            <input type="number" id="lebar" name="lebar" placeholder="Lebar" class="mb-2 2xl:text-2xl block rounded-md block w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none " required>
                            <input type="number" id="tinggi" name="tinggi" placeholder="Tinggi" class="mb-2 2xl:text-2xl block rounded-md block w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none " required>
                        </div>

                        <div class="relative w-full inline-block text-left mb-2">
                            <label class="inline-flex w-full justify-center w-full 2xl:text-2xl px-4 block rounded-md py-2 bg-[#D4C3A9] font-medium text-gray-600 outline-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                Metode Pengiriman JNE Express
                            </label>
                        </div>

                        <input type="text" id="alamat" name="alamat" placeholder="Alamat" class="mb-2 2xl:text-2xl block block rounded-md w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none " required>
                        <input type="text" id="subject" name="subject" placeholder="Subject" class="mb-2 2xl:text-2xl block block rounded-md w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none " required>
                        <textarea type="textarea" id="message" name="message" placeholder="Message" class="mb-2 2xl:text-2xl min-h-[150px] block rounded-md block w-full px-3 py-2 bg-[#D4C3A9] placeholder-gray-600 font-medium outline-none " required></textarea>
                        
                        <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                            <button type="submit" class="rounded-md hover: py-2 w-full px-4 bg-[#1D1815] 2xl:text-2xl hover:bg-[#29201C] text-white font-medium text-xl">Submit</button>
                        <?php else: ?>
                            <input type="button" class="bg-[#1D1815] font-medium p-2 text-gray-100 rounded 2xl:text-2xl w-full mt-3 hover:bg-[#29201C] add-to-cart" value="Submit" disabled>
                        <?php endif; ?>
                        
                    </form>
                </div>
            </div>
        </section>

        <?php include 'footer.php'; ?>

    </main>

    <!-- JavaScript -->
    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>

    <!-- JavaScript -->
    <script>
        function toggleDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }

        function selectBahan(bahan) {

            // Set the value of hidden input
            document.getElementById('bahan3DPValue').value = bahan;

            // Hide dropdown
            toggleDropdown('bahan3DP');
        }
    </script>

    <!-- JavaScript -->
    <script>
        document.getElementById('file').addEventListener('change', function() {
            var fileInput = document.getElementById('file');
            var fileLabel = document.getElementById('fileLabel');
            var files = fileInput.files;
            var fileNames = [];

            for (var i = 0; i < files.length; i++) {
                fileNames.push(files[i].name);
            }

            if (fileNames.length > 0) {
                fileLabel.innerText = fileNames.join(', ');
            } else {
                fileLabel.innerText = 'Upload File';
            }
        });
    </script>

    <script>
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productPrice = this.getAttribute('data-price');
                const productImg = this.getAttribute('data-img');
                const productName = this.getAttribute('data-name');
                
                fetch('./add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'product_id': productId,
                        'product_price': productPrice,
                        'product_img': productImg,
                        'product_name': productName,
                    })
                })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                });
            });
        });
    </script>


    <script src="../source/scripts/index.js"></script>
</body>
</html>