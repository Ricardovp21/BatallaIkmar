<script setup>
import { Head } from '@inertiajs/vue3';

// Simulación de tener o no token
const hasToken = false; // Cambia a false para simular no logueado
</script>

<style scoped>
.fondo {
    background-image: url('/Assets/Background/BgNaval.png');
    background-size: cover;
    background-position: center;
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: -1;
}

.barcos {
    background-image: url('/Assets/Background/Barcos.png');
    background-size: cover;
    background-position: center;
    height: 100%;
    width: 100%;
    position: absolute;
    bottom: 187px;
    animation: wave 5s linear infinite;
}

@keyframes wave {
    0% { background-position: left 0 top 0; }
    25% { background-position: center 10px; }
    50% { background-position: right 0 top 5px; }
    75% { background-position: center 10px; }
    100% { background-position: left 0 top 0; }
}

.logo {
    position: absolute;
    top: 48%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.logo img {
    z-index: 3;
    transition: all 0.3s ease-in-out;
}

.logo img:hover {
    transform: scale(1.1);
}

.contenedor-boton {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    z-index: 5;
}

.login-btn {
    background: linear-gradient(145deg, #FFD700, #FFC107);
    border: 3px solid #FFA000;
    border-radius: 15px;
    padding: 15px;
    font-size: 1.4rem;
    color: #212121;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.5);
    box-shadow: 0 6px 0 #C77800, 0 8px 25px rgba(255, 193, 7, 0.7);
    transition: all 0.3s ease;
}

.login-btn:hover {
    transform: translateY(-6px) scale(1.05);
    box-shadow: 0 12px 25px rgba(255, 193, 7, 0.9);
}

.register-btn {
    background: linear-gradient(145deg, #3CFF00FF, #4DFF07FF);
    border: 3px solid #00A043FF;
    border-radius: 15px;
    padding: 15px;
    font-size: 1.4rem;
    color: #212121;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.5);
    box-shadow: 0 6px 0 #38C700FF, 0 8px 25px rgba(28, 255, 7, 0.7);
    transition: all 0.3s ease;
}

.register-btn:hover {
    transform: translateY(-6px) scale(1.05);
    box-shadow: 0 12px 25px rgba(48, 255, 7, 0.9);
}
</style>

<template>
    <Head title="Welcome" />
    <div class="fondo"></div>
    <div class="barcos">
        <div class="logo">
            <img class="ikmar" src="/Assets/Logos/LogoIkmar.png" alt="">
        </div>
        <div class="contenedor-boton Responsive">
            <template v-if="!hasToken">
                <a href="">
                  <button type="submit" class="mb-3 btn login-btn w-100 fw-bold">Iniciar Sesión</button>
                </a>
                <a href="">
                  <button type="submit" class="mb-3 btn register-btn w-100 fw-bold">Registrarse</button>
                </a>
            </template>

            <template v-if="hasToken">
                <a href="">
                  <button type="submit" class="mb-3 btn login-btn w-100 fw-bold">Comenzar</button>
                </a>
            </template>
        </div>
    </div>
</template>
