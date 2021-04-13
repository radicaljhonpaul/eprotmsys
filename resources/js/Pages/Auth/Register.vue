<template>
<div class="min-h-screen flex sm:justify-center items-center pt-6 sm:pt-0">
    <div class="md:flex md:w-1/2 lg:w-1/2 xl:w-1/2">
        <div class="md:flex-1 p-4 rounded self-center">
            <jet-validation-errors class="mb-4" />

            <h1 class="xs:text-xs xl:text-5xl lg:text-5xl text-gray-600 text-center font-sans font-family: font-bold leading-tight">
                PROTrailMIS
            </h1>
            <p class="xs:text-xs xl:text-xl text-gray-600 tracking-widest text-center font-sans leading-tight">
                REGISTRATION
            </p>

            <p class="xs:text-xs xl:text-xl text-green-400 text-center font-sans leading-tight mt-10 hover:font-bold hover:border-purple-800 hover:text-purple-800">
<!--                 <a href="{{ route('login') }}">
                    Already have an account?
                </a> -->
                <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900"> Already registered?
                </inertia-link>
            </p>
        </div>
    </div>

    <div class="md:flex sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2" x-data="{div_id: ''}">
        <div class="max-w-md w-full space-y-8">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-6 gap-6 text-gray-500">
                    <div class="col-span-6 sm:col-span-2">
                        <jet-label for="firstname" value="Firstname" />
                        <jet-input id="firstname" type="text" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.fname" required autofocus autocomplete="fname" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <jet-label for="middlename" value="Middlename" />
                        <jet-input id="middlename" type="text" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.mname" required autofocus autocomplete="mname" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <jet-label for="lastname" value="Lastname" />
                        <jet-input id="lastname" type="text" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.lname" required autofocus autocomplete="lname" />
                    </div>

                    <!-- offices -->
                    <div class="col-span-6 sm:col-span-2">
                        <jet-label for="division" value="Division" />
                        <select id="division" name="division" x-model="div_id" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.division" required>
                            <option :value="1">REGIONAL DIRECTOR'S OFFICE</option>
                            <option :value="2">ASSISTANT REGIONAL DIRECTOR'S OFFICE</option>
                            <option :value="3">LOCAL HEALTH SUPPORT DIVISION</option>
                            <option :value="4">MANAGEMENT SUPPORT DIVISION</option>
                            <option :value="5">REGULATORY & LICENSING DIVISION</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <jet-label for="section" value="Section" />
                        <select id="section" name="section" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.section" required>
                            <option :value="1">NATIONAL NUTRITION COUNCIL</option>
                            <option :value="2">PHILHEALTH INSURANCE CORP.</option>
                            <option :value="3">ADELA SIERRA TY MEMORIAL MEDICAL CENTER</option>
                            <option :value="4">CARAGA REGIONAL HOSPITAL</option>
                            <option :value="5">DRUG TREATMENT AND REHABILITATION</option>
                            <option :value="6">OFFICE OF STRATEGIC MANAGEMENT</option>
                            <option :value="7">PDO ADS</option>
                            <option :value="8">PDO ADN</option>
                            <option :value="9">PDO SDS</option>
                            <option :value="10" x-if="div_id == 1">PDO SDN</option>
                            <option :value="11" x-if="div_id == 1">PDO PDI</option>
                            <option :value="12" x-if="div_id == 2">RESSU/HEMS</option>
                            <option :value="13" x-if="div_id == 2">PLANNING UNIT</option>
                            <option :value="14" x-if="div_id == 2">RESEARCH UNIT</option>
                            <option :value="15" x-if="div_id == 2">LEGAL UNIT</option>
                            <option :value="16" x-if="div_id == 4">FINANCE SECTION</option>
                            <option :value="17" x-if="div_id == 4">HUMAN RESOURCE MNGT & DEVELOPMENT UNIT</option>
                            <option :value="20" x-if="div_id == 4">PROCUREMENT UNIT</option>
                            <option :value="21" x-if="div_id == 4">MATERIAL MANAGMENT UNIT</option>
                            <option :value="18" x-if="div_id == 5">HEALTH FACILITY SECTION</option>
                            <option :value="19" x-if="div_id == 5">HEALTH PROGRAM SECTION</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <jet-label for="cluster" value="Cluster" />
                        <select id="cluster" name="cluster" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.cluster" required>
                            <option value="3" selected>Choose...</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <jet-label for="contact" value="Contact" />
                        <jet-input id="contact" type="text" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.contact" required autofocus autocomplete="contact" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <jet-label for="gender" value="Gender" />
                        <select id="gender" name="gender" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.gender" required>
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <jet-label for="position" value="Position" />
                        <jet-input id="position" type="text" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.position" required autofocus autocomplete="position" />
                    </div>

                    <!-- Account -->
                    <div class="col-span-full sm:col-span-3">
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="email" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.email" required />
                    </div>

                    <div class="col-span-full sm:col-span-3">
                        <jet-label for="user_role" value="Role" />
                        <select id="user_role" name="user_role" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.user_role" required>
                            <option value="" selected>Choose...</option>
                            <option value="commoner">Commoner</option>
                            <option value="division-head">Division Head</option>
                            <option value="section-head">Section Head</option>
                            <option value="cluster-head">Cluster Head</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <jet-label for="password" value="Password" />
                        <jet-input id="password" type="password" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.password" required autocomplete="new-password" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <jet-label for="password_confirmation" value="Confirm Password" />
                        <jet-input id="password_confirmation" type="password" class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.password_confirmation" required autocomplete="new-password" />
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
                    fname: '',
                    mname: '',
                    lname: '',
                    user_role: '',
                    contact: '',
                    gender: '',
                    position: '',
                    cluster: '',
                    section: '',
                    division: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    };
</script>
