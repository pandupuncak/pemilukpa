<template>
    <authorization-layout v-bind:role="role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hasil Pemilu
            </h2>
        </template>

        <template #content>
            <div>
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl my-content">
                        Hasil Pemilu
                    </div>
                    <br>

                    <div class="w-full max-w-2xl ml-auto mr-auto my-content">
                        <p v-if="status === 1">Hasil belum dapat ditampilkan. Silakan tunggu hingga Pemilu selesai.</p>
                        <div v-else-if="status === 2" class="border-4 border-opacity-100 p-8">
                            <p class="text-center text-xl">Menunjukkan hasil dari {{votes.length}} suara.</p>
                            <div id="counter" class="py-4">
                                <div >
                                    <div class="text-2xl text-center">Perolehan Suara Calon</div>

                                    <div>
                                        <div class="text-lg pt-8 text-left">
                                            1 - {{first_president_name}}
                                            <span class="text-right" style="float:right;">
                                                {{first_president}}
                                            </span>
                                        </div>
                                        <div class="w3-light-grey">
                                            <div class="w3-red" :style="`height:24px;width:${first_president * 100 / votes.length}%`"></div>
                                        </div>
                                    </div>

                                    <div v-if="second_president_name">
                                        <div class="text-lg pt-8">
                                            2 - {{second_president_name}}
                                            <span class="text-right" style="float:right;">
                                                {{second_president}}
                                            </span>
                                        </div>
                                        <div class="w3-light-grey">
                                            <div class="w3-blue" :style="`height:24px;width:${second_president * 100 / votes.length}%`"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-lg pt-8">
                                            Suara Tidak Sah
                                            <span class="text-right" style="float:right;">
                                                {{abstain_president}}
                                            </span>
                                        </div>
                                        <div class="w3-light-grey">
                                            <div class="w3-grey" :style="`height:24px;width:${abstain_president * 100 / votes.length}%`"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="outer" class="pt-4">
                                <button
                                    v-if="counting_status === 0"
                                    id="inner"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                    v-on:click="startCounter()">
                                    Mulai Perhitungan
                                </button>
                                <button
                                    v-if="counting_status === 1"
                                    id="inner"
                                    class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                                    Sedang Menghitung
                                </button>
                                <button
                                    v-if="counting_status === 2"
                                    id="inner"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                    v-on:click="startCounter()">
                                    Hitung Kembali
                                </button>
                            </div>
                        </div>
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
        data() {
            return {
                abstain_president: 0,
                first_president: 0,
                second_president: 0,

                i: 0,
                counting_status: 0, //0 = not started, 1 = counting, 2 = done

                first_president_name: "Agam Pamungkas",
                second_president_name: "Kotak Kosong",
            }
        },
        methods: {
            startCounter: function() {
                // The view model.
                var vm = this

                // Initialize
                vm.i = 0

                vm.abstain_president = 0
                vm.first_president = 0
                vm.second_president = 0

                var myVar = setInterval(myCounter, 1500)
                vm.counting_status = 1

                function myCounter() {
                    if (vm.i >= vm.votes.length) {
                        vm.counting_status = 2
                        clearInterval(myVar)
                    } else {
                        switch (vm.votes[vm.i].voted_president) {
                            case "0":
                                vm.abstain_president += 1
                                break
                            case "1":
                                vm.first_president += 1
                                break
                            case "2":
                                vm.second_president += 1
                                break
                            default:
                                break
                        }
                        vm.i += 1
                    }
                }
            }
        },
        props : ['role', 'status', 'can', 'votes']
    }
</script>
