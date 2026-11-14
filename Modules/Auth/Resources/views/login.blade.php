<!DOCTYPE html>
<html lang="en">

@include('components.v_head')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Plus Jakarta Sans', sans-serif;
        overflow: hidden;
        /* Warna Background Sky Blue yang Soft */
        background: #e0eafc; 
        background: -webkit-linear-gradient(to right, #cfdef3, #e0eafc); 
        background: linear-gradient(to right, #cfdef3, #e0eafc);
    }

    /* Background Image dengan Blur & Overlay Biru Lembut */
    .bg-focus {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(207, 222, 243, 0.8), rgba(224, 234, 252, 0.7)), 
                    url('/template/bg_smpn3_bonjol.jpg');
        background-size: cover;
        background-position: center;
        filter: blur(3px);
        z-index: -2;
    }

    /* Container Partikel */
    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: -1; 
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        position: relative;
        z-index: 10;
    }

    /* Card Design: White Premium dengan Soft Shadow Blue */
    .monitor-card {
        background: rgba(255, 255, 255, 0.95);
        width: 100%;
        max-width: 420px;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(78, 115, 223, 0.15);
        position: relative;
        animation: slideUp 0.8s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Aksen Warna di Atas */
    .card-accent {
        height: 6px;
        background: linear-gradient(90deg, #4e73df, #22c1c3);
    }

    .card-content {
        padding: 45px 40px;
        text-align: center;
    }

    .sys-title {
        font-weight: 800;
        color: #2c3e50;
        font-size: 1.6rem;
        margin-bottom: 5px;
        letter-spacing: -0.5px;
    }

    .sys-subtitle {
        color: #5d6d7e;
        font-size: 0.85rem;
        margin-bottom: 35px;
        display: block;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-group {
        text-align: left;
        margin-bottom: 22px;
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 44px;
        color: #4e73df; /* Ikon berwarna biru agar senada */
        z-index: 5;
    }

    .form-label {
        font-weight: 700;
        font-size: 0.8rem;
        color: #34495e;
        margin-bottom: 8px;
        display: block;
        margin-left: 4px;
    }

    .input-premium {
        width: 100%;
        padding: 14px 15px 14px 45px;
        background: #f4f7fe;
        border: 2px solid #e1e8f0;
        border-radius: 16px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        box-sizing: border-box;
        color: #2c3e50;
    }

    .input-premium:focus {
        border-color: #4e73df;
        background: #ffffff;
        box-shadow: 0 8px 20px rgba(78, 115, 223, 0.1);
        outline: none;
    }

    /* Tombol Login Biru Navy */
    .btn-monitor {
        background: #2c3e50;
        color: white;
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 16px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.4s;
        margin-top: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        box-shadow: 0 10px 20px rgba(44, 62, 80, 0.2);
    }

    .btn-monitor:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(44, 62, 80, 0.3);
    }

    .alert-modern {
        background: #fdeded;
        border-left: 5px solid #e74c3c;
        color: #c0392b;
        padding: 14px;
        border-radius: 12px;
        font-size: 0.85rem;
        margin-bottom: 20px;
        text-align: left;
        font-weight: 600;
    }
</style>

    <style>
        body {
            background-image: url("{{ asset('template/bg_sekolah.jpg') }}");
            background-size: cover;         
            background-position: center;   
            background-repeat: no-repeat;    
            background-attachment: fixed;    
            margin: 0;
            padding: 0;
        }
    </style>

<body>
    <div class="bg-focus"></div>
    <div id="particles-js"></div>

    <div class="login-wrapper">
        <div class="monitor-card">
            <div class="card-accent"></div>
            <div class="card-content">
                <div style="font-size: 45px; color: #4e73df; margin-bottom: 15px;">
                    <img src="{{ asset('template/tut_wuri.png') }}" alt="Logo SMPN 3 Bonjol" width="100px" height="100px">
                </div>
                
                <h1 class="sys-title">SMPN 3 BONJOL</h1>
                <span class="sys-subtitle">Monitoring Absensi & Prestasi</span>

                @if(Session::has('message'))
                    <div class="alert-modern">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ Session::get('message') }}
                    </div>
                @endif

                <form action="{{ route('proses_login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <i class="fas fa-user-circle input-icon"></i>
                        <input type="text" name="username" class="input-premium" 
                               placeholder="Masukkan Username" required autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" name="password" class="input-premium" 
                               placeholder="Masukkan Password" required>
                    </div>

                    <button type="submit" class="btn-monitor">
                        LOGIN
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('components.v_script')
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <script>
        window.onload = function() {
            particlesJS("particles-js", {
                "particles": {
                    "number": { "value": 60, "density": { "enable": true, "value_area": 800 } },
                    "color": { "value": "#4e73df" },
                    "shape": { "type": "circle" },
                    "opacity": { "value": 0.4, "random": false },
                    "size": { "value": 4, "random": true },
                    "line_linked": { 
                        "enable": true, 
                        "distance": 150, 
                        "color": "#4e73df", 
                        "opacity": 0.2, 
                        "width": 1.5 
                    },
                    "move": { 
                        "enable": true, 
                        "speed": 1.5, 
                        "direction": "none", 
                        "random": true, 
                        "out_mode": "out" 
                    }
                },
                "interactivity": {
                    "events": { 
                        "onhover": { "enable": true, "mode": "grab" },
                        "onclick": { "enable": true, "mode": "push" }
                    }
                },
                "retina_detect": true
            });
        };
    </script>
</body>
</html>