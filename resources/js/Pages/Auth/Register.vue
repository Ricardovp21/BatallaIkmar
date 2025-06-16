<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <div
        class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-12 popo"
    >
        <div class="barcos"></div>
        <img
            src="/Assets/Logos/LogoIkmar.png"
            alt="Logo Ikmar"
            class="w-48 h48 mb-8"
        />
        <div
            class="w-full max-w-md bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-8 shadow-2xl text-white"
        >
            <h1 class="text-3xl font-bold text-center mb-6">
                Bienvenido a Ikmar Battleship
            </h1>

            <div
                v-if="status"
                class="mb-4 text-green-400 text-sm text-center font-medium"
            >
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="Text" value="Text" class="text-white" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="fistname"
                        placeholder="Paquito Pérez"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="email" value="Email" class="text-white" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="example@example.com"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel
                        for="password"
                        value="Password"
                        class="text-white"
                    />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel
                        for="password_confirmation"
                        value="Confirmar Password"
                        class="text-white"
                    />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>
                <button type="submit" class="mb-3 btn login-btn w-full fw-bold">
                    Registrarse
                </button>
            </form>
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
    background-image: url("/Assets/Background/FondoNoBarcos.png");
    background-size: cover;
    background-position: center;
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: -1;
}

.barcos {
    background-image: url("/Assets/Background/Barcos.png");
    background-size: cover;
    background-position: center;
    height: 100%;
    width: 100%;
    position: absolute;
    bottom: 187px;
    animation: wave 5s linear infinite;
}

@keyframes wave {
    0% {
        background-position: left 0 top 0;
    }
    25% {
        background-position: center 10px;
    }
    50% {
        background-position: right 0 top 5px;
    }
    75% {
        background-position: center 10px;
    }
    100% {
        background-position: left 0 top 0;
    }
}
</style>
