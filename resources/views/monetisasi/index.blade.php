<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Harga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        .body {
            font-family: Arial, sans-serif;
        }
        .pricing-section {
            background-color: #E6F4FE;
            padding: 50px 0;
        }

        .pricing-card {
            border-radius: 15px;
            height: 450px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .pricing-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .pricing-card .card-title {
            color: #1E1E1E;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .card-price {
            font-size: 2rem;
            font-weight: 800;
            color: #1E1E1E;
        }

        .pricing-section button {
            font-size: 1rem;
            font-weight: 300;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            margin-top: auto;
            background-color: #19508C;
            border: 1px solid #19508C;
            color: white;
            text-align: center;
            transition: background-color 0.3s;
            width: 246px;
            flex-shrink: 0; 
            align-self: center; 
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 1);
        }

        .btn-toggle.active {
            background-color: #19508C;
            color: white;
        }

        .featured-card {
            background-color: #19508C;
            color: white;
        }

        .pricing-card ul {
            list-style-type: disc;
            padding-left: 10px;
            margin-bottom: 1rem;
            text-align: left;
        }

        .pricing-card li {
            margin-bottom: 0.5rem;
        }

        .pricing-section button:hover {
            background-color:#174171;
            color: white;
        }

        .custom-ul {
            color: #757575;
            align-self: center;
        }

        .pricing-section {
            margin: 50px auto;
        }

        .pricing-card {
            padding: 20px;
            border-radius: 10px;
        }

        #pricingCards .col-md- {
            display: flex;
            justify-content: center;
        }

        .featured-card ul {
            list-style-type: disc;
            padding-left: 80px; 
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<section id="harga" class="pricing-section my-5">
    <div class="container text-center">
        <h2 class="mb-4" style="font-weight:700"> PAKET HARGA</h2>
        <div class="row justify-content-center" id="pricingCards">
            <div class="col-12 col-md-4 mb-4">
                <div class="card pricing-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Gratis</h5>
                        <h2 class="card-price">Rp0<span class="fs-6">/Bulan</span></h2>
                        <hr>
                        <ul class="list-unstyled mb-4 custom-ul">
                            <li><span class="bullet-point"></span> 1 Tim, maksimal 10 anggota</li>
                            <li><span class="bullet-point"></span> Log aktivitas tersedia</li>
                            <li><span class="bullet-point"></span> Tidak dapat unduh laporan <br></br></li>
                        </ul>
                        <a href="https://wa.me/6282297634460?text=Halo,%20saya%20ingin%20mendaftar%20Paket%20Per%20Tahun">
                            <button class="btn btn-primary btn-block">Berlangganan</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4 monthly-card">
                <div class="card pricing-card featured-card shadow-lg">
                    <div class="card-body">
                    <h5 class="card-title text-white">Per Bulan</h5>
                        <h2 class="card-price text-white">Rp135.000<span class="fs-6">/Bulan</span></h2>
                        <hr class="bg-light">
                        <ul class="list-unstyled text-white mb-4 custom ul">
                            <li><span class="bullet-point"></span> Tim dan anggota tanpa batas</li>
                            <li><span class="bullet-point"></span> Log aktivitas lengkap</li>
                            <li><span class="bullet-point"></span> Dapat unduh laporan</li>
                            <li><span class="bullet-point"></span> Layanan konsultasi</li>
                        </ul>
                        <a href="https://wa.me/6282297634460?text=Halo,%20saya%20ingin%20mendaftar%20Paket%20Per%20Tahun">
                            <button class="btn btn-primary btn-block" style="background-color:#ffffff; color:#19508C">Berlangganan</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4 monthly-card">
                <div class="card pricing-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Per Tahun</h5>
                        <h2 class="card-price">Rp1.458.000<span class="fs-6">/Tahun</span></h2>
                        <hr>
                        <ul class="list-unstyled mb-4 custom-ul">
                            <li><span class="bullet-point"></span> Tim dan anggota tanpa batas</li>
                            <li><span class="bullet-point"></span> Log aktivitas lengkap</li>
                            <li><span class="bullet-point"></span> Dapat unduh laporan</li>
                            <li><span class="bullet-point"></span> Layanan konsultasi</li>
                        </ul>
                        <a href="https://wa.me/6282297634460?text=Halo,%20saya%20ingin%20mendaftar%20Paket%20Per%20Tahun">
                            <button class="btn btn-primary btn-block">Berlangganan</button>
                        </a>
                    </div>
                </div>
            </div>
        </section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>