<template>
    <guest-layout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img src="/img/logo.png" width="48" height="48" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">ERROR!</strong>
                    <span class="block sm:inline">{{error}}</span>
                </div>

                <div class="text-md">
                    Selamat Datang. Anda perlu update password terlebih dahulu sebelum melanjutkan.
                </div>

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <jet-label for="current_password" value="Current Password" />
                        <jet-input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                        <jet-input-error :message="form.error('current_password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="password" value="New Password" />
                        <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" />
                        <jet-input-error :message="form.error('password')" class="mt-2" />
                    </div>
                    <p v-if="this.form.password.length > 0 && this.form.password.length < 8" class="text-red-600 text-xs">Password minimal 8 karakter</p>

                    <div class="mt-4">
                        <jet-label for="password_confirmation" value="Confirm Password" />
                        <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                        <jet-input-error :message="form.error('password_confirmation')" class="mt-2" />
                    </div>
                    <p v-if="this.form.password !== this.form.password_confirmation && this.form.password_confirmation.length > 0" class="text-red-600 text-xs">Password tidak sesuai</p>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </guest-layout>
</template>

<script>
import GuestLayout from "../../Layouts/GuestLayout"
import JetButton from "../../Jetstream/Button"
import JetInput from "../../Jetstream/Input"
import JetLabel from "../../Jetstream/Label"
import JetInputError from "../../Jetstream/InputError"

export default {
    components: {
        GuestLayout,
        JetButton,
        JetInput,
        JetLabel,
        JetInputError
    },
    data() {
        return {
            form: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: '',
            }, {
                bag: 'updatePassword',
            }),
        }
    },
    methods: {
        submit() {
            this.form.put(route('mypassword.reset.submit'), {
                preserveScroll: true
            }).then(() => {
                this.$refs.current_password.focus()
            })
        },
    },
    props: ['error']
}
</script>
