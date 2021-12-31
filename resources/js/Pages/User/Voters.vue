<template>
    <authorization-layout v-bind:role="role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Pemilih
            </h2>
        </template>

        <template #content>
            <div>
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200 my-content">
                    <div class="text-2xl">
                        Daftar Pemilih
                    </div>

                    <table class="table-auto mr-auto ml-auto" v-if="all_users || pending_users">
                        <caption>Showing {{ all_users.length + pending_users.length }} user data</caption>
                        <thead>
                            <tr>
                                <th class="px-4 py-2">NIM</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Status Pemilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in pending_users" :key="user.nim">
                                <td class="border px-4 py-2">{{ user.nim }}</td>
                                <td class="border px-4 py-2">{{ user.name}}</td>
                                <td class="border px-4 py-2">{{ user.email }}</td>
                                <td class="border px-4 py-2" :style="`color: ${color[user.vote_status]}`">
                                    {{ status[user.vote_status] }}
                                </td>
                            </tr>

                            <tr v-for="user in all_users" :key="user.nim">
                                <td class="border px-4 py-2">{{ user.nim }}</td>
                                <td class="border px-4 py-2">{{ user.name }}{{(user.role_id === 1 || user.role_id === 2) ? " - ADMIN" : ''}}</td>
                                <td class="border px-4 py-2">{{ user.email }}</td>
                                <td class="border px-4 py-2" :style="`color: ${color[user.vote_status]}`">
                                    {{ status[user.vote_status] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
        data() {
            return {
                color: {
                    "approved" : "green",
                    "pending" : "orange",
                    "rejected" : "red",
                    "notyet" : "red"
                },
                status: {
                    "approved" : 'Telah memilih',
                    "pending" : 'Menunggu verifikasi',
                    "rejected" : 'Belum memilih, ditolak',
                    "notyet" : 'Belum memilih',
                },
            }
        },
        props : ['all_users', 'role', 'pending_users']
    }
</script>
