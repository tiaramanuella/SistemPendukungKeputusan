<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #a8dadc, #457b9d);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        canvas#background-canvas {
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1; /* Di belakang konten lain */
        }

            .welcome-container {
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .button {
            padding: 0.8rem 2rem;
            font-size: 1rem;
            color: #fff;
            background-color: #4a90e2;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .button:hover {
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: bounce 1.5s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
    <canvas id="background-canvas"></canvas>
    <div class="welcome-container">
        <div class="icon">
            <i class='bx bxs-graduation'></i>
        </div>
        <h1>Selamat Datang</h1>
        <p>Sistem Pendukung Keputusan Untuk Mencari Sekolah Swasta Terbaik Di Sulut</p>
        <button class="button" onclick="enterSite()">Mulai</button>
    </div>

    <script>
        function enterSite() {
            const button = document.querySelector('.button');
            button.textContent = 'Memuat...';
            button.style.backgroundColor = '#357ABD';
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 1000);
        }

        // Elemen JavaScript keren untuk latar belakang partikel
        const canvas = document.getElementById('background-canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        const particlesArray = [];
        const numberOfParticles = 100;

        window.addEventListener('resize', function() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            init();
        });

        class Particle {
            constructor(){
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 5 + 1;
                this.speedX = Math.random() * 3 - 1.5;
                this.speedY = Math.random() * 3 - 1.5;
                this.color = 'rgba(255, 255, 255, 0.7)';
            }
            update(){
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
                this.draw();
            }
            draw(){
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function init(){
            particlesArray.length = 0;
            for (let i = 0; i < numberOfParticles; i++){
                particlesArray.push(new Particle());
            }
        }

        function animate(){
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particlesArray.forEach(particle => particle.update());
            requestAnimationFrame(animate);
        }

        init();
        animate();
    </script>
</body>
</html>

