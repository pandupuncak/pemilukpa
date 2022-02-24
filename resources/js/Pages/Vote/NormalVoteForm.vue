<template>
    <form class="w-full max-w-full ml-auto mr-auto" @submit.prevent="submit">
        <div class="grid grid-cols-1 pt-4">
            <div class="flex flex-wrap">
                <div class="px-3">
                    <label class="text-center uppercase block tracking-wide text-gray-700 text-2xl font-bold mb-2" for="president">
                        Calon Ketua BP KPA ITB
                    </label>

                    <div class="grid grid-cols-2 gap-4 py-4 sm:w-4/5 lg:w-3/5 xl:w-1/2 mx-auto">
                        <div>
                            <img class="rounded-lg" src="/img/agam.png"
                                v-bind:style="p1Style"
                                v-on:click="selectPresident(1, $event)"
                                alt="kandidat"
                                />
                        </div>
                        <div>
                            <img class="rounded-lg" src="/img/empty-box.png"
                                v-bind:style="p2Style"
                                v-on:click="selectPresident(2, $event)"
                                alt="kandidat"
                                />
                        </div>

                        <div class="outer">
                            <div class="inner mycheckbox">
                                <p>{{president_candidates[1]}}</p>
                            </div>
                        </div>
                        <div class="outer">
                            <div class="inner">
                                <p>{{president_candidates[2]}}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="$page.errors.president">{{ $page.errors.president[0] }}</div>
                </div>
            </div>

            <p class="text-gray-600 text-sm italic pb-4 text-center">
                Petunjuk:<br>Anda boleh mengosongkan pilihan Anda dengan cara <i>uncheck</i> pilihan Anda.
            </p>
        </div>

        <div class="container p-8">
            <h3 class="text-center">Konten Kandidat: Agam Pamungkas</h3>
            <h4 class="text-center">Visi</h4>
            <p class="text-center lg:px-32">
                Terciptanya KPA-ITB sebagai Organisasi Kesenian Angklung yang menjadi tempat 
                berkembang dan pulang bagi anggotanya, serta adaptif terhadap perubahan.
            </p>

            <h4 class="text-center">Misi</h4>
            <ol class="lg:px-32">
                <li>1. Menyediakan wadah berhimpun yang dapat menjadi tempat mengembangkan potensi diri dan menjaga partisipasi anggotanya.</li>
                <li>2. Meningkatkan kemampuan musikalitas dan angklung anggota melalui pelatihan dan penampilan guna menjaga kelestarian angklung.</li>
                <li>3. Mengenalkan KPA-ITB sebagai organisasi kesenian angklung yang adaptif di lingkungan ITB pada khususnya dan di luar ITB pada umumnya.</li>
            </ol>
        </div>

        <div id="outer">
            <button
                v-if="isLoading"
                id="inner"
                class="bg-blue-300 text-white font-bold py-2 px-4 border border-blue-400 rounded"
                disabled
            >
                Please Wait...
            </button>
            <button
                v-else
                id="inner"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                type="submit">
                Submit
            </button>
        </div>

        <div v-if="isLoading" class="text-center pt-4 text-orange-500">
            Harap tunggu...<br>proses dapat memakan waktu beberapa detik.
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            selected_president: 0,
            p1Style: {
                boxShadow: "none",
            },
            p2Style: {
                boxShadow: "none"
            },
            selectedStyle: {
                boxShadow: "0px 0px 6px 3px rgba(30, 144, 255,1)"
            },
            unselectedStyle: {
                boxShadow: "none"
            },
            president_candidates: {
                0: "TIDAK MEMILIH",
                1: "Agam Pamungkas",
                2: "KOTAK KOSONG",
            },
            isLoading: false,
        }
    },
    methods: {
        selectPresident(num, event){
            // event.preventDefault()
            switch (num) {
                case 1:
                    if (this.selected_president == 1) {
                        this.selected_president = 0
                        this.p1Style = this.unselectedStyle
                    } else {
                        this.selected_president = 1
                        this.p1Style = this.selectedStyle
                        this.p2Style = this.unselectedStyle
                    }
                    break
                case 2:
                    if (this.selected_president == 2) {
                        this.selected_president = 0
                        this.p2Style = this.unselectedStyle
                    } else {
                        this.selected_president = 2
                        this.p1Style = this.unselectedStyle
                        this.p2Style = this.selectedStyle
                    }
                    break
                default:
                    break;
            }
        },
        submit() {
            this.$confirm(
                {
                    message:
                        `Pilihan Anda: ${this.president_candidates[this.selected_president]}.` +
                        ` Apakah Anda sudah yakin untuk mengirimkan suara Anda?`,
                    button: {
                        yes: 'Ya',
                        no: 'Batal',
                    },
                    /**
                     * Callback Function
                     * @param {Boolean} confirm
                     */
                    callback: confirm => {
                        if (confirm) {
                            let data = new FormData()
                            data.append('president', this.selected_president)

                            this.isLoading = true;
                            this.$inertia.post(route('vote.create'), data)
                        }
                    }
                }
            )
        },
    },
}
</script>
