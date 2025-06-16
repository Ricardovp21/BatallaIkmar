<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

// Props con valores por defecto
defineProps({
    canResetPassword: {
        type: Boolean,
        default: false
    },
    status: {
        type: String,
        default: ''
    }
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Iniciar Sesión" />

    <div class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-12 popo">
            <div class="barcos"></div>
        <img src="/Assets/Logos/LogoIkmar.png" alt="Logo Ikmar" class="w-48 h-48 mb-8" />

        <div class="w-full max-w-md p-8 text-white border shadow-2xl bg-white/5 backdrop-blur-md border-white/10 rounded-2xl">
            <h1 class="mb-6 text-3xl font-bold text-center">Bienvenido de nuevo</h1>

            <div v-if="status" class="mb-4 text-sm font-medium text-center text-green-400">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="email" value="Email" class="text-white" />
                    <TextInput
                        id="email"
                        type="email"
                        class="block w-full mt-1 text-white placeholder-gray-200 border rounded-lg bg-white/10 border-white/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="example@example.com"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="Password" class="text-white" />
                    <TextInput
                        id="password"
                        type="password"
                        class="block w-full mt-1 text-white placeholder-gray-200 border rounded-lg bg-white/10 border-white/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-700">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2">Recordarme</span>
                    </label>

                    <Link v-if="canResetPassword" :href="route('password.request')" class="text-gray-700 hover:underline">
                        ¿Olvidaste tu contraseña?
                    </Link>
                </div>

                <div>
                    <button type="submit" class="w-full mb-3 btn login-btn fw-bold">
                        Iniciar Sesión
                    </button>
                </div>
            </form>

            <p class="mt-6 text-sm text-center text-white/70">
                ¿No tienes cuenta?
                <Link href="/register" class="ml-1 text-gray-700 hover:underline">
                    Regístrate
                </Link>
            </p>
        </div>
    </div>
</template>

<style scoped>
.login-btn {
    background: linear-gradient(145deg, #ffd700, #ffc107);
    border: 3px solid #ffa000;
    border-radius: 15px;
    padding: 15px;
    font-size: 1.4rem;
    color: #212121;
    text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
    box-shadow: 0 6px 0 #c77800, 0 8px 25px rgba(255, 193, 7, 0.7);
    transition: all 0.3s ease;
}

.login-btn:hover {
    transform: translateY(-6px) scale(1.05);
    box-shadow: 0 12px 25px rgba(255, 193, 7, 0.9);
}
.popo {
    background-image: url('/Assets/Background/FondoNoBarcos.png');
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

</style>
