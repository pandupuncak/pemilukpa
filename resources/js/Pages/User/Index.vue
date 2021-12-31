<template>
    <authorization-layout v-bind:role="role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Management
            </h2>
        </template>

        <template #content>
            <div>
                <div v-if="info" class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                    <p>{{info}}</p>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl">
                        Import Data Pengguna
                    </div>
                    <div class="text-md">
                        max 250 pengguna per import
                    </div>
                    <br />

                    <form class="w-full max-w-sm" @submit.prevent="submit">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="csv">
                                    CSV File
                                </label>
                                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="csv" type="file">
                                <p class="text-gray-600 text-xs italic">Format: tanpa nama kolom, tiap baris ada dua kolom yaitu NIM dan Nama</p>
                            </div>
                        </div>

                        <div class="md:flex md:items-center">
                            <div class="md:w-1/3"></div>
                            <div class="md:w-2/3">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" type="submit">
                                    Import
                                </button>
                            </div>
                        </div>
                    </form>

                    <p v-if="imported_users">Imported {{row_count}} user data.</p>
                    <table class="table-auto" v-if="imported_users">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">NIM</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Password</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in imported_users" :key="user.nim">
                                <td class="border px-4 py-2">{{ user.nim }}</td>
                                <td class="border px-4 py-2">{{ user.name }}</td>
                                <td class="border px-4 py-2">{{ user.email }}</td>
                                <td class="border px-4 py-2">{{ user.password }}</td>
                                <td class="border px-4 py-2">{{ user.status ? "Sukses" : "Gagal" }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl">
                        Kirim Password
                    </div>
                    <div class="text-md">
                        Format: kolom NIM, email, password; tanpa nama kolom
                    </div>
                    <br />

                    <form class="w-full max-w-sm" @submit.prevent="submitEmails">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="csv2">
                                    CSV File
                                </label>
                                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="csv2" type="file">
                                <p class="text-gray-600 text-xs italic">Format: kolom NIM, email, password; tanpa nama kolom</p>
                            </div>
                        </div>

                        <div class="md:flex md:items-center">
                            <div class="md:w-1/3"></div>
                            <div class="md:w-2/3">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" type="submit">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </form>

                    <p v-if="info">{{info}}</p>

                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200 my-content">
                        <div class="text-2xl">
                            Daftar Pengguna
                        </div>
                        <br />

                        <p v-if="all_users">Showing {{all_users.length}} user data.</p>
                        <table class="table-auto mr-auto ml-auto" v-if="all_users">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">NIM</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in all_users" :key="user.nim">
                                    <td class="border px-4 py-2">{{ user.nim }}</td>
                                    <td class="border px-4 py-2">{{ user.name }}</td>
                                    <td class="border px-4 py-2">{{ user.email }}</td>
                                    <td class="border px-4 py-2">{{ user.role_id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </template>
    </authorization-layout>
</template>

<script>
    import AuthorizationLayout from './../../Layouts/AuthorizationLayout'

    export default {
        components: {
            AuthorizationLayout,
        },

        methods: {
            submit() {
                let data = new FormData()
                data.append('csv', csv.files[0], 'nim-name.csv')

                this.$inertia.post(route('users.import'), data)
            },
            submitEmails() {
                let data = new FormData()
                data.append('csv', csv2.files[0], 'nim-email-passwords.csv')

                this.$inertia.post(route('users.send-passwords'), data)
            },
        },
        props : ['role', 'imported_users', 'all_users', 'row_count', 'info']
    }
</script>
