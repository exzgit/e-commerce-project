<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCTS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="../source/styles/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <div class="w-full h-screen bg-[#E6E6E6] flex flex-col items-center">
            <div class="flex z-20 fixed items-end bg-[#E6E6E6] h-16 w-full px-16">
                <nav class="flex items-end h-16 w-full border-b-2 border-gray-400 items-center">
                    <a href="./profile.php" class="text-center flex items-center justify-center"><i class="fas fa-home"></i></a>
                    <span class="text-gray-800 m-2 p-2 font-bold text-xl">THE M.I.C</span>
                </nav>
            </div>

            <!-- Harga -->
            <div id="harga" class="w-full flex justify-center">
                <div class="w-1/3 pt-20">
                    
                    <div class="w-full shadow-xl flex p-4 flex-col bg-white pb-4 border rounded-md gap-y-2">
                        <div class="flex gap-x-2 items-center">
                            <div class="flex flex-col space-y-1 w-full">
                                <label for="inputemail" class="text-md font-medium">Email</label>
                                <input type="email" name="email" placeholder="Masukan email Anda" id="inputemail" class="p-1 outline-none border-2 rounded-md ">
                                <label for="inputalamat" class="text-md font-medium">Alamat</label>
                                <input type="text" name="alamat" placeholder="Masukan alamat Anda" id="inputalamat" class="p-1 outline-none border-2 rounded-md ">
                            </div>
                            <img src="#" alt="products" class="min-w-32 h-32 border border-gray-300 rounded-md">
                        </div>                     
                        <label for="inputmessage" class="text-md font-medium">Message</label>
                        <textarea name="message" placeholder="Masukan pesan Anda" id="inputmessage" class="p-1 min-h-48 max-h-48a outline-none border-2 rounded-md"></textarea>
                        <button class=" p-2 text-center w-[100%] bg-black font-medium rounded-md px-3 text-white">
                            Mulai pembelian
                        </button>
                    </div>
                    
                </div>
            </div>

        </div>
    </main>

    <script src="../source/scripts/index.js">
       
    </script>
</body>
</html>