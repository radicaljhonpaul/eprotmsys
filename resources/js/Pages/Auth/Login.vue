<template>
<div class="lg:flex">
    <div class="lg:w-1/2 xl:max-w-screen-sm">
        <div class="py-12 bg-purple-100 lg:bg-white flex justify-center lg:justify-start lg:px-12">
            <div class="cursor-pointer flex items-center">
                <img class="fill-current" style="height:80px;width:80px;" src="/images/eprotrackmonsys.png">
                <div class="text-2xl text-purple-800 tracking-wide ml-2 font-semibold">
                    ePROTrailMIS
                    <p class="text-xs text-gray-500 mt-0">e-PR/PO Trailing & Monitoring Information System</p>
                </div>
            </div>
        </div>
        <div class="mt-10 px-12 sm:px-24 md:px-48 lg:px-12 lg:mt-16 xl:px-24 xl:max-w-2xl">
            <jet-validation-errors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="mt-12">
                <form @submit.prevent="submit">
                    <div>
                        <div for="email" class="text-sm font-bold text-gray-700 tracking-wide">Email Address</div>
                        <input id="email" class="w-full text-lg py-2 border-b border-purple-300 focus:outline-none text-purple-500 focus:border-purple-500" type="email" v-model="form.email" placeholder="ceojhonpaul@gmail.com" required autofocus>
                    </div>
                    <div class="mt-8">
                        <div class="flex justify-between items-center">
                            <div for="password" class="text-sm font-bold text-gray-700 tracking-wide">
                                Password
                            </div>
                            <div>
                                <span class="text-xs font-display font-semibold text-purple-600 hover:text-purple-800
                                cursor-pointer">
                                    <inertia-link v-if="canResetPassword" :href="route('password.request')">
                                        Forgot your password?
                                    </inertia-link>
                                </span>
                            </div>
                        </div>
                        <input id="password" class="w-full text-lg py-2 border-b border-purple-300 text-purple-500 focus:outline-none focus:border-purple-500" type="password" placeholder="Enter your password" v-model="form.password" required autocomplete="current-password">
                    </div>
                    <div class="mt-10">
                        <button class="bg-purple-500 text-gray-100 p-4 w-full rounded-full tracking-wide
                        font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-purple-600
                        shadow-lg" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Sign In <i class="fas fa-sign-in"></i>
                        </button>
                    </div>
                </form>
                <div class="mt-12 text-sm font-display font-semibold text-gray-700 text-center">
                    Don't have an account ? <a class="cursor-pointer text-purple-600 hover:text-purple-800" :href="route('register')">Sign up</a>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden lg:flex items-center justify-center flex-1 h-screen" style="background-image: url('/images/login/Docs.jpg'); background-repeat: no-repeat; background-size: cover;">
    </div>
</div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

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

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
