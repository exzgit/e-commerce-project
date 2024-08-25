<?php
session_start();
include 'db.php';
$is_logged_in = isset($_SESSION['user_id']);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$sql = "SELECT COUNT(*) as TOTALORDER FROM cart_users";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $totalOrder = $row['TOTALORDER'];
} else {
    echo "Gagal menghitung total order: " . $conn->error;
}

$sql = "SELECT COUNT(*) as TOTALUSER FROM usertb";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $totalUser = $row['TOTALUSER'];
} else {
    echo "Gagal menghitung total user: " . $conn->error;
}

if ($is_logged_in) {
    $admin_id = $_SESSION['user_id'];
    $sql = "SELECT ADMINNAME FROM admindb WHERE ADMINID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();


    $sql = "SELECT * FROM cart_users";
    $result = $conn->query($sql);
        
    $alluser = "SELECT * FROM usertb";
    $userresult = $conn->query($alluser);
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The MIC - Pekerjaan Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #F3F4F6;
        }

        .header {
            background: #776055;
            color: white;
        }

        .zoom-animation{
            transform: scale(100%);
            transition: all ease-in-out 0.3s;
        }

        .zoom-animation:hover{
            transform: scale(102%);
            transition: all ease-in-out 0.3s;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }


        .btn-primary {
            background-color: #19191B;
            color: white;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #111113;
        }

        .price-tag {
            background-color: rgba(37, 99, 235, 1);
            color: white;
        }

        ::-webkit-scrollbar {
            width: 0px; 
            height: 0px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888; 
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        ::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 10px;
        }
    </style>
</head>

<body class="font-sans">

    <header class="w-full py-4 shadow-md header fixed top-0 z-10">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="index.php" class="text-2xl font-bold"><i class="fas fa-home"></i></a>
            <div class="flex items-center space-x-4">
                <?php if ($is_logged_in): ?>
                    <img src="display_image_admin.php" class="w-10 h-10 rounded-full border-2 border-white object-cover">
                    <span class="font-semibold"><?= htmlspecialchars($username); ?></span>
                <?php endif; ?>
                <a href="./logout.php" class="text-xl btn-primary px-4 py-2"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>

    <main class="">
        <div class="container mx-auto flex flex-col md:flex-row">

            <aside class="w-full mt-24 h-[80vh] ml-6 md:w-1/4 bg-white shadow-lg rounded-lg mb-6 md:mb-0 md:mr-6">
                <h1 class="text-2xl font-bold mb-6 p-2 bg-[#604A40] rounded-t-lg text-white text-center">The MIC</h1>
                <div class="flex px-6 flex-col items-center">
                    <?php if ($is_logged_in): ?>
                        <img src="display_image_admin.php" class="w-32 h-32 rounded-full border-4 border-[#776055] object-cover mb-4">
                        <h1 class="text-gray-700 font-bold text-2xl"><?= htmlspecialchars($username); ?></h1>
                    <?php else: ?>
                        <img src="../source/image/default.jpg" class="w-32 h-32 rounded-full border-4 border-[#776055] object-cover mb-4">
                        <h1 class="text-gray-700 font-bold text-2xl">ADMINNAME</h1>
                    <?php endif; ?>
                    <div class="w-full bg-gray-200 h-1 my-4 rounded"></div>
                </div>
            </aside>

            <div class="block pt-24 w-full gap-y-4 space-y-4 mr-6 h-[100vh] pb-8 overflow-y-auto overflow-x-hidden">
                <section class="w-full p-6 bg-white rounded-lg shadow-lg">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6 gradient-text p-2 border-b">Statistic</h1>

                    <div class="flex flex-wrap gap-6">
                        <div class="w-fit border shadow-md hover:shadow-lg rounded-[25px] bg-white p-8 aspect">
                            <div class="h-12">
                            <svg fill="#412F27" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                class="h-12 w-12" viewBox="0 0 287.755 287.755"
                                xml:space="preserve">
                            <g>
                            <path d="M134.16,279.13c-15.24,0-26.715-12.31-26.715-27.544c0-15.162,11.475-26.638,26.715-26.638
                                c15.162,0,27.472,11.476,27.472,26.638C161.626,266.821,149.316,279.13,134.16,279.13z"/>
                            <path d="M265.515,176.575c-1.682,7.085-2.275,19.503-6.762,25.244c-2.708,3.465-6.773,5.626-11.943,5.626H92.21
                                c-9.962,0-18.056-8.022-18.056-18.003c0-6.461-18.507-98.199-25.497-132.633c-1.453-7.146-8.551-12.995-15.834-13.061
                                l-14.711-0.141c-19.786,0-18.075-18.774-18.075-18.774c0.384-6.626,2.642-10.581,5.434-12.911
                                c5.597-4.668,18.231-3.008,25.347-3.02l12.874-0.024c22.146,0,30.883,12.661,34.317,22.929c2.312,6.917,3.495,18.735,5.05,25.857
                                l22.104,100.829c1.561,7.122,8.737,12.893,16.021,12.893H222.31c7.29,0,14.412-5.771,15.907-12.91l16.507-78.486
                                c2.132-9.217,5.566-13.627,9.086-15.501c6.425-3.444,19.882,1.63,22.416,8.455c3.759,10.157-0.595,27.37-0.595,27.37
                                S272.691,146.484,265.515,176.575z"/>
                            <path d="M224.382,279.13c-15.18,0-26.649-12.31-26.649-27.544c0-15.162,11.47-26.638,26.649-26.638
                                c15.162,0,27.525,11.476,27.525,26.638C251.908,266.821,239.544,279.13,224.382,279.13z"/>
                            <path d="M135.085,153.335c-4.984,0-9.025-4.053-9.025-9.043c0-4.978,4.042-9.031,9.025-9.031c4.996,0,9.031,4.053,9.031,9.031
                                C144.116,149.283,140.087,153.335,135.085,153.335z"/>
                            <path d="M171.209,153.335c-4.983,0-9.024-4.053-9.024-9.043c0-4.978,4.041-9.031,9.024-9.031c4.979,0,9.031,4.053,9.031,9.031
                                C180.241,149.283,176.188,153.335,171.209,153.335z"/>
                            <path d="M207.323,153.335c-4.99,0-9.031-4.053-9.031-9.043c0-4.978,4.041-9.031,9.031-9.031c4.978,0,9.025,4.053,9.025,9.031
                                C216.348,149.283,212.3,153.335,207.323,153.335z"/>
                            <path d="M117.022,117.21c-4.972,0-9.037-4.035-9.037-9.021c0-4.981,4.065-9.035,9.037-9.035c5.008,0,9.043,4.053,9.043,9.035
                                C126.06,113.175,122.024,117.21,117.022,117.21z"/>
                            <path d="M153.147,99.161c4.984,0,9.025,4.044,9.025,9.028c0,4.986-4.041,9.028-9.025,9.028c-4.989,0-9.031-4.042-9.031-9.028
                                C144.116,103.205,148.158,99.161,153.147,99.161z"/>
                            <path d="M189.266,99.161c4.984,0,9.025,4.044,9.025,9.028c0,4.986-4.041,9.028-9.025,9.028c-4.99,0-9.031-4.042-9.031-9.028
                                C180.235,103.205,184.276,99.161,189.266,99.161z"/>
                            <path d="M225.379,99.161c4.983,0,9.024,4.044,9.024,9.028c0,4.986-4.041,9.028-9.024,9.028c-4.99,0-9.031-4.042-9.031-9.028
                                C216.348,103.205,220.389,99.161,225.379,99.161z"/>
                            <path d="M207.323,81.104c-4.99,0-9.031-4.053-9.031-9.022c0-4.993,4.041-9.031,9.031-9.031c4.978,0,9.025,4.032,9.025,9.031
                                C216.348,77.051,212.3,81.104,207.323,81.104z"/>
                            <path d="M171.209,81.104c-4.983,0-9.024-4.053-9.024-9.022c0-4.993,4.041-9.031,9.024-9.031c4.979,0,9.031,4.032,9.031,9.031
                                C180.241,77.051,176.188,81.104,171.209,81.104z"/>
                            <path d="M135.085,81.104c-4.984,0-9.025-4.053-9.025-9.022c0-4.993,4.042-9.031,9.025-9.031c4.996,0,9.031,4.032,9.031,9.031
                                C144.116,77.051,140.087,81.104,135.085,81.104z"/>
                            </g>
                            </svg>
                            </div>
                            <div class="my-2">
                                <h2 class="text-4xl font-bold"><span><?php echo $totalOrder; ?></span></h2>
                            </div>

                            <div>
                                <p class="mt-2 font-sans text-base font-medium text-gray-500">Pesanan masuk</p>
                            </div>
                        </div>
                        <div class="w-fit border shadow-md hover:shadow-lg rounded-[25px] bg-white p-8 aspect">
                            <div class="h-12">
                                <svg class="h-full fill-white stroke-[#412F27]" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <div class="my-2">
                                <h2 class="text-4xl font-bold"><span><?php echo $totalUser; ?></span></h2>
                            </div>

                            <div>
                                <p class="mt-2 font-sans text-base font-medium text-gray-500">Registered users</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="w-full p-6 bg-white rounded-lg shadow-lg">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6 gradient-text border-b">Pekerjaan Saya</h1>

                    <div class="flex flex-wrap gap-2">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php if ($row['PRODUCTS'] == "Konfirmasi"): ?>
                                    <a href="detailcartadmin.php?idproduct=<?php echo urlencode($row['ID']); ?>" class="relative w-48 h-64 zoom-animation border bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg shadow-md">
                                    <?php
                                        if (isset($row['IMGPRODUCT']) && !empty($row['IMGPRODUCT'])) {
                                            $imgData = $row['IMGPRODUCT'];
                                            $imgMimeType = 'image/jpeg';
                                            $imgSrc = "data:{$imgMimeType};base64,{$imgData}";
                                        } else {
                                            // $imgSrc = "../source/image/productimg.jpg";
                                            $imgSrc = "https://img.freepik.com/free-photo/assortment-square-sides-geometric-cubes_23-2150832992.jpg";

                                        }
                                    ?>
                                    <img src="<?php echo $imgSrc; ?>" class="object-cover w-full h-32">
                                    <div class="p-4">
                                        <h2 class="text-lg font-medium text-gray-800 truncate"><?php echo htmlspecialchars($row['SUBJECT']); ?></h2>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($row['STATUS']); ?></p>
                                        <div class="flex justify-between items-center mt-2">
                                            <p class="text-lg font-semibold text-[#776055]"><?php echo 'Rp' . number_format($row['TOTALPRICING'], 2, ',', '.'); ?></p>
                                            <?php if ($row['TOTALPRICING'] == 0): ?>
                                                <span class="bg-blue-100 text-blue-600 py-1 px-2 text-xs rounded-full">Gratis</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                                <?php else: ?>
                                    <a href="detailpekerjaan.php?idproduct=<?php echo urlencode($row['ID']); ?>" class="relative w-48 h-64 zoom-animation border bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md ">
                                    <?php
                                        if (isset($row['IMGPRODUCT']) && !empty($row['IMGPRODUCT'])) {
                                            $imgData = $row['IMGPRODUCT'];
                                            $imgMimeType = 'image/jpeg';
                                            $imgSrc = "data:{$imgMimeType};base64,{$imgData}";
                                        } else {
                                            // $imgSrc = "../source/image/productimg.jpg";
                                            $imgSrc = "https://img.freepik.com/free-photo/assortment-square-sides-geometric-cubes_23-2150832992.jpg";
                                        }
                                    ?>
                                    <img src="<?php echo $imgSrc; ?>" class="object-cover w-full h-32">
                                    <div class="p-4">
                                        <h2 class="text-lg font-medium text-gray-800 truncate"><?php echo htmlspecialchars($row['SUBJECT']); ?></h2>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($row['STATUS']); ?></p>
                                        <div class="flex justify-between items-center mt-2">
                                            <p class="text-lg font-semibold text-[#776055]"><?php echo 'Rp' . number_format($row['TOTALPRICING'], 2, ',', '.'); ?></p>
                                            <?php if ($row['TOTALPRICING'] == 0): ?>
                                                <span class="bg-blue-100 text-blue-600 py-1 px-2 text-xs rounded-full">Gratis</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="col-span-3 text-center text-gray-500">Tidak ada produk dalam keranjang.</p>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="w-full p-6 bg-white rounded-lg shadow-lg">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6 gradient-text border-b">User Registered</h1>

                    <div class="flex flex-wrap gap-x-4 h-[300px] overflow-y-auto">
                    <?php if ($userresult->num_rows > 0): ?>
                            <?php while ($user = $userresult->fetch_assoc()): ?>
                                <div class="flex zoom-animation bg-white w-64 h-32 shadow-md border items-center gap-x-2 justify-center p-2 rounded-md">
                                    <div class="h-16 w-16">
                                        <?php if($row['USERIMG']): ?>
                                            $imgData = base64_encode($user['USERIMG']);
                                            $imgSrc = "data:{$user['IMGTYPE']};base64,{$imgData}";
                                        <?php else: ?>
                                            $imgSrc = "../source/image/default.jpg";
                                        <?php endif; ?>
                                        <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="<?php echo $imgSrc; ?>" alt="" />
                                    </div>
                                    <div>
                                        <div class="text-md font-medium text-secondary-500"><?php echo $user['USERNAME']; ?></div>
                                        <div class="text-sm font-medium text-gray-500"><?php echo $user['REGISTRATION_DATE']; ?></div>
                                        <div class="text-xs text-secondary-400"><?php echo $user['USERMAIL']; ?></div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="col-span-3 text-center text-gray-500">Tidak ada produk dalam keranjang.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </div>

        </div>
    </main>
</body>

</html>
