<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600"
                        >Remember me</span
                    >
                </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@500;700&display=swap');

.login-page { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Arial; color:#0f172a; background:#fff; min-height:100vh; }
.wrap { max-width:1100px; margin: 18px auto; padding: 0 20px; }
.crumb { color:#6b7280; margin: 18px 0; }
.crumb span { color:#9b1b1b; }

.card { width:420px; margin: 36px auto; padding: 28px; background:#fff; border-radius:10px; box-shadow: 0 20px 50px rgba(2,6,23,0.06); text-align:center; }
.card h2 { font-family:'Playfair Display', serif; margin-bottom: 18px; font-size:24px; letter-spacing:2px; }
.form { display:flex; flex-direction:column; gap:12px; }
.form input { height:44px; padding: 10px 12px; border:1px solid #e6e9ef; border-radius:6px; font-size:14px; outline:none; }
.form input:focus { border-color:#111827; box-shadow: 0 6px 18px rgba(2,6,23,0.04); }
.btn-login { margin-top:6px; height:44px; background:#0f172a; color:#fff; border:none; border-radius:6px; font-weight:700; cursor:pointer; }
.btn-login:hover { opacity:0.95 }

.links { display:flex; justify-content:space-between; margin-top:12px; font-size:14px; color:#111827; }
.links a { color:#374151; text-decoration:none; }

.divider { margin-top:18px; color:#6b7280; font-size:13px; }
.socials { display:flex; gap:12px; justify-content:center; margin-top:12px; }
.social { display:inline-flex; align-items:center; justify-content:center; padding:8px 16px; border-radius:6px; color:#fff; text-decoration:none; font-weight:600; }
.social.fb { background:#3b5998 }
.social.gg { background:#db4a39 }

@media (max-width: 768px){ .card { width: 92%; margin: 18px auto; padding:20px; } }

</style>
