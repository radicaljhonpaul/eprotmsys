<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>

            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="'/storage/'+user.profile_photo_path" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remove Photo
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <!-- <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div> -->

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4 text-gray-500">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required/>
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 text-gray-500">
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3">
                        <!-- <div class="col-span-6 sm:col-span-4"> -->
                            <jet-label for="fname" value="Firstname" />
                            <jet-input id="fname" type="text" class="mt-1 block w-4/5" v-model="form.fname" required/>
                            <jet-input-error :message="form.errors.fname" class="mt-2" />
                        <!-- </div> -->
                    </div>

                    <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3">
                        <!-- <div class="col-span-6 sm:col-span-4"> -->
                            <jet-label for="mname" value="Middlename" />
                            <jet-input id="mname" type="text" class="mt-1 block w-4/5" v-model="form.mname" required/>
                            <jet-input-error :message="form.errors.mname" class="mt-2" />
                        <!-- </div> -->
                    </div>

                    <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3">
                        <!-- <div class="col-span-6 sm:col-span-4"> -->
                            <jet-label for="lname" value="Lastname" />
                            <jet-input id="lname" type="text" class="mt-1 block w-4/5" v-model="form.lname" required/>
                            <jet-input-error :message="form.errors.lname" class="mt-2" />
                        <!-- </div> -->
                    </div>

                </div>
            </div>

            <!-- contact, position, gender -->
            <div class="col-span-6 text-gray-500">
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3">
                        <!-- <div class="col-span-6 sm:col-span-4"> -->
                            <jet-label for="contact" value="Contact" />
                            <jet-input id="contact" type="text" class="mt-1 block w-4/5" v-model="form.contact" required/>
                            <jet-input-error :message="form.errors.contact" class="mt-2" required/>
                        <!-- </div> -->
                    </div>

                    <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3">
                        <!-- <div class="col-span-6 sm:col-span-4"> -->
                            <jet-label for="position" value="Position" />
                            <jet-input id="position" type="text" class="mt-1 block w-4/5" v-model="form.position" required/>
                            <jet-input-error :message="form.errors.position" class="mt-2" required/>
                        <!-- </div> -->
                    </div>

                    <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3">
                        <!-- <div class="col-span-6 sm:col-span-4"> -->
                            <jet-label for="lname" value="Gender" />
                            <select id="gender" name="gender" class="mt-1 block w-4/5 px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.gender" required>
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <jet-input-error :message="form.errors.gender" class="mt-2" />
                        <!-- </div> -->
                    </div>

                </div>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    // name: this.user.name,
                    email: this.user.email,
                    fname: this.user.fname,
                    mname: this.user.mname,
                    lname: this.user.lname,
                    contact: this.user.contact,
                    gender: this.user.gender,
                    position: this.user.position,
                    email: this.user.email,
                    photo: null,
                }),
                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => (this.photoPreview = null),
                });
            },
        },
    }
</script>
