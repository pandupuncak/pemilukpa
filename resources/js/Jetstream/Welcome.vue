<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl heading">
                Selamat datang di aplikasi Pemilu KPA ITB!
            </div>

            <div class="mt-6 my-content text-lg" :style="`color: ${messageColor[voteStatus]}`">
                {{ messageContent[voteStatus] }}
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="flex items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold heading"><p>Panduan Pemilihan</p></div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-lg text-gray-500 my-content">
                        1. Pergi ke halaman pemilihan<br>
                        2. Pilih kandidat Calon Ketua BP<br>
                        3. Submit form<br>
                        4. Suara Anda masuk dan terhitung dalam sistem<br><br>

                        Data penting terkait pemilu dapat diakses di sini:<br>
                        <a
                            href="https://linktr.ee/PemiluBP50"
                            target="_blank"
                            class="text-indigo-700"
                        >
                            https://linktr.ee/PemiluBP50
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                <div class="flex items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold heading"><p>Pilih Kandidat</p></div>
                </div>

                <div class="ml-12">
                    <div v-if="isBeforeVotingPeriod">
                        <div class="mt-2 text-lg text-gray-500">
                            <span class="text-red-500">Pemilu belum dibuka.</span><br>
                        </div>
                    </div>

                    <div v-else-if="isAfterVotingPeriod">
                        <div class="mt-2 text-lg text-gray-500">
                            <span class="text-red-500">Pemilu telah selesai.</span><br>
                        </div>
                    </div>

                    <div v-else-if="voteStatus === 'notyet' || voteStatus === 'rejected'">
                        <div class="mt-2 text-lg text-gray-500 my-content">
                            Gunakan hak suara Anda.
                        </div>

                        <inertia-link :href="route('vote')">
                            <div class="mt-3 flex items-center text-lg font-semibold text-indigo-700">
                                    <div>Voting Sekarang</div>

                                    <div class="ml-1 text-indigo-500">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-right w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                            </div>
                        </inertia-link>
                    </div>

                    <div v-else>
                        <div class="mt-2 text-lg text-gray-500">
                            Anda telah memilih. Saat ini Anda tidak dapat melakukan pemilihan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from './../Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
        data() {
            return {
                messageColor: {
                    "approved" : "green",
                    "pending" : "orange",
                    "rejected" : "red",
                    "notyet" : "red",
                },
                messageContent: {
                    "notyet" : "Anda belum menggunakan hak suara Anda",
                    "pending" : "Anda telah menggunakan hak suara Anda. Panitia akan memverifikasi berkas Anda.",
                    "approved" : "Anda telah menggunakan hak suara Anda.",
                    "rejected" : "Anda belum menggunakan hak suara Anda. Berkas anda sebelumnya telah ditolak oleh panitia.",
                },
            }
        },
        props : ['voteStatus', 'isBeforeVotingPeriod', 'isAfterVotingPeriod']
    }
</script>
