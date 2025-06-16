<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>
<style>
.fondo {
    background-image: url('/Assets/Background/BgNaval.png');
    background-size: cover;
    background-position: center;
    height: 100vh;
    width: 100%;
}
</style>
    <Head title="Welcome" />
<div class="fondo">
    
</div>
