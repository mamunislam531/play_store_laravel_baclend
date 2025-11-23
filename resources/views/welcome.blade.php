<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Classic Shop Backend</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Animated gradient background */
    body {
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #1e3c72, #2a5298, #4facfe, #00f2fe);
        background-size: 400% 400%;
        animation: gradientBG 20s ease infinite;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow: hidden;
    }

    @keyframes gradientBG {
        0% {background-position: 0% 50%;}
        50% {background-position: 100% 50%;}
        100% {background-position: 0% 50%;}
    }

    /* Floating logo above card */
    .logo {
        position: absolute;
        top: 10%;
        width: 150px;
        height: 150px;
        animation: floatLogo 3s ease-in-out infinite;
    }

    .logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }

    @keyframes floatLogo {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* Glassmorphic card */
    .card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        border-radius: 25px;
        padding: 60px 80px;
        text-align: center;
        box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.25);
        animation: cardEnter 1.5s ease forwards;
        opacity: 0;
        transform: translateY(50px);
        position: relative;
        z-index: 1;
    }

    @keyframes cardEnter {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animated gradient typing text */
    .animate-text {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(90deg, #00f2fe, #4facfe, #0072ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        overflow: hidden;
        border-right: 0.15em solid #00f2fe;
        white-space: nowrap;
        letter-spacing: .1em;
        animation: typing 4s steps(35, end), blink-caret .8s step-end infinite;
    }

    @keyframes typing {
        from { width: 0; }
        to { width: 100%; }
    }

    @keyframes blink-caret {
        from, to { border-color: transparent; }
        50% { border-color: #00f2fe; }
    }

    /* Subtitle */
    .subtitle {
        margin-top: 20px;
        font-size: 1.2rem;
        color: rgba(255,255,255,0.9);
        opacity: 0;
        animation: fadeIn 2s 1.5s forwards;
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    /* Hover effect */
    .card:hover {
        transform: translateY(-10px) scale(1.02);
        transition: all 0.4s ease;
    }

    /* Floating particle animation */
    .particle {
        position: absolute;
        width: 10px;
        height: 10px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        animation: floatParticle linear infinite;
    }

    @keyframes floatParticle {
        0% { transform: translateY(0) translateX(0); opacity: 0.2; }
        50% { transform: translateY(-100px) translateX(50px); opacity: 0.6; }
        100% { transform: translateY(-200px) translateX(0); opacity: 0; }
    }

</style>
</head>
<body>

<!-- Floating logo -->
<div class="logo">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNlfb5x2dOc6YCu3nAca1SYsDRWI6g23H9MfbXRRddPPUaxQvoEbLHrUr6n0X4CN5-6Lw&usqp=CAU" alt="Classic Shop Logo">
</div>

<!-- Glassmorphic card -->
<div class="card">
    {{-- <div class="animate-text">Play Store App Backend is Running</div> --}}
    <div class="subtitle">sThis backend is built for the Play Store App API.</div>
</div>

<!-- Particles (optional) -->
<script>
    const particleCount = 20;
    for(let i=0;i<particleCount;i++){
        let p = document.createElement('div');
        p.classList.add('particle');
        p.style.left = Math.random() * window.innerWidth + 'px';
        p.style.top = Math.random() * window.innerHeight + 'px';
        p.style.width = 5 + Math.random()*8 + 'px';
        p.style.height = p.style.width;
        p.style.animationDuration = 5 + Math.random()*5 + 's';
        document.body.appendChild(p);
    }
</script>

</body>
</html>
