<template>
<div class="min-h-screen flex sm:justify-center items-center py-10">
    <!-- <div class="md:flex md:w-1/2 lg:w-1/2 xl:w-1/2">
        <div class="md:flex-1 p-4 rounded self-center">
            <jet-validation-errors class="mb-4" />

            <h1 class="xs:text-xs xl:text-5xl lg:text-5xl text-gray-600 text-center font-sans font-family: font-bold leading-tight">
                PROTrailMIS
            </h1>
            <p class="xs:text-xs xl:text-xl text-gray-600 tracking-widest text-center font-sans leading-tight">
                REGISTRATION
            </p>

            <p class="xs:text-xs xl:text-xl text-green-400 text-center font-sans leading-tight mt-10 hover:font-bold hover:border-purple-800 hover:text-purple-800">
                <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900"> Already registered?
                </inertia-link>
            </p>
        </div>
    </div> -->

    <div class="max-w-lg w-full space-y-8 px-5" x-data="{div_id: ''}">
        <form @submit.prevent="submit">
            <div class="grid grid-cols-6 gap-6 text-gray-500">
                <div class="col-span-6 sm:col-span-2">
                    <jet-label for="firstname" value="Firstname" />
                    <input id="firstname" type="text" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.fname" required autofocus autocomplete="fname" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <jet-label for="middlename" value="Middlename" />
                    <input id="middlename" type="text" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.mname" required autofocus autocomplete="mname" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <jet-label for="lastname" value="Lastname" />
                    <input id="lastname" type="text" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.lname" required autofocus autocomplete="lname" />
                </div>

                <!-- offices -->
                <div class="col-span-6 sm:col-span-3">
                    <jet-label for="division" value="Division" />
                    <select id="division" name="division" x-model="div_id" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.division" @change='getOfficesCluster(form.cluster,form.division),getOffices(form.cluster,form.division)' required>
                        <option v-for='divData in Division_List' :key="divData" :value='divData.id'>{{ divData.name }}</option>
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3" v-if="form.division == 2 || form.division == 3">
                    <jet-label for="cluster" value="Cluster" />
                    <select id="cluster" name="cluster" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.cluster" @change='getOffices(form.cluster,form.division)'>
                        <option :value="0">None</option>
                        <option v-for='clus in Cluster_List' :key="clus" :value='clus.id'>{{ clus.name }}</option>
                    </select>
                </div>

                <div v-bind:class="{ 'col-span-6 sm:col-span-3': form.division != 2 || form.division != 3, 'col-span-6 sm:col-span-6': form.division == 2 || form.division == 3}">
                    <jet-label for="office" value="Office" />
                    <select id="office" name="office" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.office">
                        <option v-for='office in Office_List' :key="office" :value='office.id'>{{ office.name }}</option>
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <jet-label for="contact" value="Contact" />
                    <input id="contact" type="text" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.contact" required autofocus autocomplete="contact" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <jet-label for="gender" value="Gender" />
                    <select id="gender" name="gender" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.gender" required>
                        <option value="Male" selected>Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-6">
                    <jet-label for="position" value="Position" />
                    <input id="position" type="text" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.position" required autofocus autocomplete="position" />
                </div>

                <!-- Account -->
                <div class="col-span-full sm:col-span-3">
                    <jet-label for="email" value="Email" />
                    <input id="email" type="email" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.email" required />
                </div>

                <div class="col-span-full sm:col-span-3">
                    <jet-label for="user_role" value="Role" />
                    <select id="user_role" name="user_role" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.user_role" required>
                        <option value="office" selected>Office</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <jet-label for="password" value="Password" />
                    <input id="password" type="password" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.password" required autocomplete="new-password" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <jet-label for="password_confirmation" value="Confirm Password" />
                    <input id="password_confirmation" type="password" class="mt-1 block rounded-none w-full px-4 py-3 border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.password_confirmation" required autocomplete="new-password" />
                </div>
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </jet-button>
            </div>
        </form>
    </div>
</div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import 'alpinejs'
	import Mylib from '@/CustomFunctions/Mylib.js';	

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        data() {
            return {
                form: this.$inertia.form({
                    fname: null,
                    mname: null,
                    lname: null,
                    user_role: null,
                    contact: null,
                    gender: null,
                    position: null,
                    office: 0,
                    cluster: 0,
                    division: null,
                    email: null,
                    password: null,
                    password_confirmation: '',
                    terms: false,
                }),
                Division_List: [],
				Cluster_List: [],
				Office_List: [],
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            },
            // Methods for Dependent Dropdown
            getOfficesDivision: function(){
				Mylib.getOfficesDivision(this);
            },
			getOfficesCluster: function(cluster,division) {
				Mylib.getOfficesCluster(this,cluster,division);
            },
			getOffices: function(cluster,division) {
				Mylib.getOffices(this,cluster,division);
            },
        },
        created: function(){
            this.getOfficesDivision();
        },
    };
</script>
