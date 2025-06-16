<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: Boolean,
    status: String,
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
    <div
        class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-12"
    >
        <img
            src="/Assets/Logos/LogoIkmar.png"
            alt="Logo Ikmar"
            class="w-48 h48 mb-8"
        />
        <div
            class="w-full max-w-md bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-8 shadow-2xl text-white"
        >
            <h1 class="text-3xl font-bold text-center mb-6">
                Bienvenido de nuevo
            </h1>

            <div
                v-if="status"
                class="mb-4 text-green-400 text-sm text-center font-medium"
            >
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
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

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-700">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ml-2">Recordarme</span>
                    </label>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-gray-700 hover:underline"
                    >
                        ¿Olvidaste tu contraseña?
                    </Link>
                </div>

                <div>
                    <button
                        type="submit"
                        class="mb-3 btn login-btn w-full fw-bold"
                    >
                        Iniciar Sesión
                    </button>
                </div>
            </form>

            <p class="text-center mt-6 text-sm text-white/70">
                ¿No tienes cuenta?
                <Link
                    href="/register"
                    class="text-gray-700 hover:underline ml-1"
                    >Regístrate</Link
                >
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
</style>
