<template>
    <form class="w-full max-w-full ml-auto mr-auto" @submit.prevent="submit">
        <div class="grid grid-cols-1 pt-4">
            <div class="flex flex-wrap">
                <div class="px-3">
                    <label class="text-center uppercase block tracking-wide text-gray-700 text-2xl font-bold mb-2" for="president">
                        Calon Ketua BP KPA ITB
                    </label>

                    <div class="grid grid-cols-3 gap-4 py-4 mx-auto">
                        <div class="image-container">
                            <img class="rounded-lg" src="/img/blank-profile.png"
                                v-on:click="selectPresident(1, $event)"
                                alt="kandidat"
                                />
                            <div id="pres1-overlay" class="overlay" v-bind:style="president_candidates[1].overlayStyle">
                                <img
                                    v-if="president_candidates[1].isSelected"
                                    :src="president_candidates[1].overlayImage"
                                    alt="img" />
                            </div>
                        </div>
                        <div class="image-container">
                            <img class="rounded-lg" src="/img/blank-profile.png"
                                v-on:click="selectPresident(2, $event)"
                                alt="kandidat"
                                />
                            <div id="pres2-overlay" class="overlay" v-bind:style="president_candidates[2].overlayStyle">
                                <img
                                    v-if="president_candidates[2].isSelected"
                                    :src="president_candidates[2].overlayImage"
                                    alt="img" />
                            </div>
                        </div>
                        <div class="image-container">
                            <img class="rounded-lg" src="/img/blank-profile.png"
                                v-on:click="selectPresident(3, $event)"
                                alt="kandidat"
                                />
                            <div id="pres3-overlay" class="overlay" v-bind:style="president_candidates[3].overlayStyle">
                                <img
                                    v-if="president_candidates[3].isSelected"
                                    :src="president_candidates[3].overlayImage"
                                    alt="img" />
                            </div>
                        </div>


                        <div class="outer">
                            <div class="inner mycheckbox">
                                <p>{{president_candidates[1].name}}</p>
                            </div>
                        </div>
                        <div class="outer">
                            <div class="inner">
                                <p>{{president_candidates[2].name}}</p>
                            </div>
                        </div>
                        <div class="outer">
                            <div class="inner">
                                <p>{{president_candidates[3].name}}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="$page.errors.president">{{ $page.errors.president[0] }}</div>
                </div>
            </div>

            <p class="text-gray-600 text-lg lg:text-md italic pb-4 text-center">
                Petunjuk:<br>Klik secara terurut untuk memilih urutan kandidat pilihan Anda.<br>
                Anda dapat melakukan uncheck pada gambar.
            </p>

            <p class="text-gray-600 text-lg pb-4 text-center">
                Urutan preferensi: {{getPreferencesNumberName()}}
            </p>
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
            president_candidates: [
                {
                    name: "TIDAK MEMILIH",
                },
                {
                    name: "CALON PERTAMA",
                    overlayStyle: { opacity: "0" },
                    overlayImage: "",
                    isSelected: false,
                },
                {
                    name: "CALON KEDUA",
                    overlayStyle: { opacity: "0" },
                    overlayImage: "",
                    isSelected: false,
                },
                {
                    name: "CALON KETIGA",
                    overlayStyle: { opacity: "0" },
                    overlayImage: "",
                    isSelected: false,
                },
            ],
            isLoading: false,
            preferences: [],
        }
    },
    methods: {
        updatePreferencesStyle() {
            // Reset all style
            for (let i = 0; i < this.president_candidates.length; i++) {
                if (i !== 0) {
                    this.president_candidates[i].overlayStyle = { opacity: "0" }
                    this.president_candidates[i].overlayImage = ""
                    this.president_candidates[i].isSelected = false
                }
            }

            for (let i = 0; i < this.preferences.length; i++) {
                const num = this.preferences[i];
                this.president_candidates[num].overlayStyle = { opacity: "1" }
                this.president_candidates[num].overlayImage = `/img/pref${i+1}.png`
                this.president_candidates[num].isSelected = true
            }
        },
        selectPresident(num, event){
            // event.preventDefault()
            console.log("Clicked president num " + num)

            if (this.president_candidates[num].isSelected) {
                // pop out president with number "num"
                var index = this.preferences.indexOf(num);
                if (index !== -1) {
                    this.preferences.splice(index, 1);
                }

                // Update styling for every preference
                this.updatePreferencesStyle()
            } else {
                // append prisedent with number "num"
                this.preferences.push(num)

                // Update styling for every preference
                this.updatePreferencesStyle()
            }
        },
        getPreferencesNumberName(){
            // From array [1, 2, 3] to string "1 NAMA - 2 NAMA - 3 NAMA"
            let ret = ""
            for (let i = 0; i < this.preferences.length; i++) {
                const num = this.preferences[i];
                const name = this.president_candidates[num].name

                ret += `${num} ${name}`
                if (i !== this.preferences.length - 1) {
                    ret += " - "
                }
            }
            return ret || "-"
        },
        getPreferencesString(){
            // From array [1, 2, 3] to string "1-2-3"
            const ret = this.preferences.join('-')
            return ret
        },
        submit() {
            const numOfPresident = 3
            if (this.preferences.length === numOfPresident) {
                this.$confirm(
                    {
                        message:
                            `Urutan preferensi: ${this.getPreferencesString()}.` +
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
                                data.append('president', this.getPreferencesString())

                                this.isLoading = true;
                                this.$inertia.post(route('vote.create'), data)
                            }
                        }
                    }
                )
            } else {
                this.$confirm(
                    {
                        message: `Anda belum memilih urutan seluruh kandidat`,
                        button: {
                            yes: 'OK'
                        }
                    }
                )
            }
        },
    },
}
</script>

<style scoped>
    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        pointer-events: none;
    }

    .image-container {
        position: relative;
    }

    .overlay img {
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>
