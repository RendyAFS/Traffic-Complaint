<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <link rel="shortcut icon" href="assets/Logo_Web.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ffffff;
            /* Warna latar belakang putih */
        }

        .maintenance-container {
            text-align: center;
        }

        .image {
            width: 30%;
        }

        .text_maintenece {
            font-size: 25px;
            font-weight: bold;
        }


        @media (max-width: 800px) {
            .maintenance-container {
                text-align: center;
                width: 100%;
                /* Mengurangi lebar kontainer pada layar kecil */
                margin: 0 auto;
                /* Posisi tengah pada layar kecil */
            }

            .image {
                width: 50%;
                /* Memperbesar gambar pada layar kecil */
            }

            .text_maintenece {
                font-size: 18px;
                /* Mengurangi ukuran teks pada layar kecil */
            }
        }
        @media (max-width: 450px) {
            .maintenance-container {
                text-align: center;
                width: 90%;
                /* Mengurangi lebar kontainer pada layar kecil */
                margin: 0 auto;
                /* Posisi tengah pada layar kecil */
            }

            .image {
                width: 75%;
                /* Memperbesar gambar pada layar kecil */
            }

            .text_maintenece {
                font-size: 18px;
                /* Mengurangi ukuran teks pada layar kecil */
            }
        }
    </style>
</head>

<body>
    <div class="maintenance-container">
        <!-- <img src="assets/Logo_Web.png" alt="Image" class="image"> -->
        <p class="text_maintenece">Website Sedang Maintenance</p>
        <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
