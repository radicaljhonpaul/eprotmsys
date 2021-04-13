<template>
<div class="min-h-screen flex sm:justify-center items-center pt-6 sm:pt-0">
    <div class="md:flex md:w-1/2 lg:w-1/2 xl:w-1/2">
        <div class="md:flex-1 p-4 rounded self-center">
            <jet-validation-errors class="mb-4" />

            <h1 class="xs:text-xs xl:text-5xl lg:text-5xl text-gray-600 text-center font-sans font-family: font-bold leading-tight">
                <img class="object-contain h-48 w-full" src="/images/eprotrackmonsys.png">
                PROTrailMIS
            </h1>

            <p class="xs:text-xs xl:text-xl text-green-400 text-center font-sans leading-tight my-8 hover:font-bold hover:border-purple-800 hover:text-purple-800">
                <a :href="route('register')">
                    Don't have an account?
                </a>
            </p>

        </div>
    </div>

    <div class="md:flex md:w-1/2 lg:w-1/2 xl:w-1/2">
        <div class="max-w-md w-full space-y-8">
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="text-gray-600">
                    <jet-label for="email" value="Email" />
                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
                </div>

                <div class="mt-4 text-gray-600">
                    <jet-label for="password" value="Password" />
                    <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <jet-checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <inertia-link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                        Forgot your password?
                    </inertia-link>

                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
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
