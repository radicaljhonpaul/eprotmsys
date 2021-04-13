<template>
    <div class="gradient">
        <nav class="nav fixed w-full flex flex-wrap items-center text-gray-500 justify-between px-4 bg-white">
            <div class="flex flex-no-shrink items-center mr-6 py-3 text-grey-darkest">
                <img class="fill-current h-8 mr-2 w-8" src="/images/eprotrackmonsys.png">
                <span class="font-semibold text-xl tracking-tight">PROTrailMIS</span>
            </div>

                <input class="menu-btn hidden" type="checkbox" id="menu-btn">
                <label class="menu-icon block cursor-pointer md:hidden px-2 py-4 relative select-none" for="menu-btn">
                    <span class="navicon bg-grey-darkest flex items-center relative"></span>
                </label>

            <ul class="menu border-b md:border-none flex justify-end list-reset m-0 w-full md:w-auto">
            <li class="border-t md:border-none">
                <inertia-link :href="route('login')" id="navAction" class="block md:inline-block px-4 py-3 no-underline text-grey-darkest hover:text-grey-darker">
                        Sign in <i class="fas fa-sign-in-alt"></i>
                </inertia-link>
            </li>

            <li class="border-t md:border-none">
                <inertia-link v-if="canRegister" :href="route('register')" id="navAction" class="block md:inline-block px-4 py-3 no-underline text-grey-darkest hover:text-grey-darker">
                        Register <i class="fas fa-user-alt"></i>
                </inertia-link>
            </li>


            </ul>
        </nav>


        <!--Hero-->
        <div class="pt-24">
          <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
            <!--Left Col-->
            <div class="flex flex-col sm:text-base xl:text-6xl lg:text-5xl w-full md:w-1/2 justify-center items-start text-center md:text-left">
                <h1 class="my-4 font-bold leading-tight">
                    e-Purchase Request & Order Tracking and Monitoring System
                </h1>
            </div>
            <!--Right Col-->
            <div class="w-1/2 text-center">
                <img class="object-contain h-5/6 w-full xs:h-96" style="object-fit: contain;" src="/images/main.png">
            </div>
          </div>
        </div>

        <div class="relative -mt-12 lg:-mt-24">
          <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
                <path
                  d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                  opacity="0.100000001"
                ></path>
                <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
              </g>
              <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path
                  d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"
                ></path>
              </g>
            </g>
          </svg>
        </div>

        <section class="bg-white border-b py-8">
          <div class="container max-w-5xl mx-auto m-8 sm:text-base xl:text-6xl lg:text-5xl">
            <h3 class="w-full my-2 font-bold leading-tight text-center text-gray-800">
              Main Features
            </h3>
            <div class="w-full mb-4">
              <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>

            <div class="flex flex-wrap">
              <div class="w-5/6 sm:w-1/2 p-6">
                <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                  PR and PO Tracking
                </h3>
                <p class="text-gray-600 mb-8">
                  Record and Tracks PR and PO Documents, as to when and where it's current location and where will it's next distination.
                  <br />
                  <br />
                </p>
              </div>
              <div class="w-full sm:w-1/2 p-6">
                <img style="height: 200px; width: 100%; object-fit: contain;" src="/images/track.png">
              </div>
            </div>

            <div class="flex flex-wrap flex-col-reverse sm:flex-row">
              <div class="w-full sm:w-1/2 p-6 mt-6">
                <img style="height: 300px; width: 100%; object-fit: contain;" src="/images/monandassess.png">
              </div>
              <div class="w-full sm:w-1/2 p-6 mt-6">
                <div class="align-middle">
                  <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                    Monitor and Assess
                  </h3>
                  <p class="text-gray-600 mb-8">
                    Provides monitoring and assessment as to document handling
                    <br />
                    <br />
                  </p>
                </div>
              </div>
            </div>

            <div class="flex flex-wrap">
              <div class="w-5/6 sm:w-1/2 p-6">
                <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                  Notifications
                </h3>
                <p class="text-gray-600 mb-8">
                  Provides notification for all incoming, outgoing, and jammed documents.
                  <br />
                  <br />
                </p>
              </div>
              <div class="w-full sm:w-1/2 p-6">
                <img style="height: 200px; width: 100%; object-fit: contain;" src="/images/notify.png">
              </div>
            </div>
          </div>
        </section>

        <!--Footer-->
        <footer class="footer-1 py-8 sm:py-12">
            <div class="container mx-auto px-4">
                <div class="sm:flex sm:flex-wrap sm:-mx-4 md:py-4">
                    <div class="px-4 sm:w-1/2 md:w-1/4 xl:w-1/6">
                        <h5 class="text-xl font-bold mb-6">Features</h5>
                        <ul class="list-none footer-links">
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">PR and PO Tracking</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">Random Monitor and Assess</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">Team Notifications</a>
                            </li>
                        </ul>
                    </div>
                    <div class="px-4 sm:w-1/2 md:w-1/4 xl:w-1/6 mt-8 md:mt-0">
                        <h5 class="text-xl font-bold mb-6">About</h5>
                        <ul class="list-none footer-links">
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">Team</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">PROTrailMIS</a>
                            </li>
                        </ul>
                    </div>
                    <div class="px-4 sm:w-1/2 md:w-1/4 xl:w-1/6 mt-8 md:mt-0">
                        <h5 class="text-xl font-bold mb-6">Help</h5>
                        <ul class="list-none footer-links">
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">Support</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">Help Center</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="border-b border-solid border-transparent hover:border-purple-800 hover:text-purple-800">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                    <div class="px-4 mt-4 sm:w-1/3 xl:w-1/6 sm:mx-auto xl:mt-0 xl:ml-auto">
                        <h5 class="text-xl font-bold mb-6 sm:text-center xl:text-left">Stay connected</h5>
                        <div class="flex sm:justify-center xl:justify-start">
                            <a href="" class="w-8 h-8 border border-2 border-white-400 rounded-full text-center py-1 text-white-600 hover:text-white hover:bg-blue-600 hover:border-blue-600">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="" class="w-8 h-8 border border-2 border-white-400 rounded-full text-center py-1 ml-2 text-white-600 hover:text-white hover:bg-red-600 hover:border-red-600">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
    .gradient {
        background: linear-gradient(90deg, #d53369 0%, #daae51 100%);
    }
</style>

<script>
    export default {
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        }
    };
</script>
