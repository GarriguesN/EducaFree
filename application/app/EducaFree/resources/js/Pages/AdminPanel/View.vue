<script setup>
    import PanelLayout from "@/Layouts/PanelLayout.vue";
    import { Head} from '@inertiajs/vue3';


    const autoURL = window.location.origin;
    const urlBase = `${autoURL}/storage/ImagesCourses/`;
</script>


<template>
    <Head title="Dashboard"/>
    <PanelLayout title="Dashboard">
        <section class="relative">
          <div class="grid">
            <div class="col-span-1 flex flex-col items-center justify-center row">
                <div class="flex flex-col justify-center items-center" v-if="$page.props.course.img">
                    <img class="w-[10rem]" :src="urlBase+$page.props.course.img">
                    <p class="text-center mt-2 text-sm text-gray-400">Image preview</p>
                </div>
                <div class="text-center mt-2 text-sm text-gray-400" v-else>No image loaded</div>
                <h2 class="text-3xl text-center text-black mt-8 font-bold dark:text-white">{{ $page.props.course.name }}</h2>
                <h4 class="text-xl text-center text-black mt-8 font-bold dark:text-white">{{ $page.props.course.description }}</h4>
            </div>
        </div>
    </section>

    <section id="lessons">
    <div class="container px-5 py-16 mx-auto sm:px-20">
      <div class="md:flex w-full h-full">
        <div class="border-b border-gray-200 min-w-52">
          <ul class="flex-col text-sm font-medium text-gray-500 md:me-4 md:mb-0 min-w-full"
              id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content"
              data-tabs-active-classes="text-blue-700 hover:text-blue-700 border-blue-700"
              data-tabs-inactive-classes="text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300"
              role="tablist">
            <li v-for="(lesson, index) in $page.props.lessons" :key="index" class="me-2" role="presentation">
              <button
                      :class="{ 'border-blue-700': activeTab === index }"
                      class="inline-block p-4 border-b-2 rounded-t-lg w-full flex justify-between" :id="'lesson-tab-' + index"
                      :data-tabs-target="'#lesson-content-' + index" type="button" role="tab"
                      :aria-controls="'lesson-content-' + index"
                      :aria-selected="activeTab === index">{{index+1}}. {{ lesson.name }}
                    </button> 
            </li>
          </ul>
        </div>

        <div id="default-styled-tab-content" class="bg-gray-50 text-medium text-gray-500 rounded-lg w-full max-w-full">
          <div v-for="(lesson, index) in $page.props.lessons" :key="index"
               :class="{ hidden: activeTab !== index }" class="p-4 rounded-lg bg-gray-50 max-w-full"
               :id="'lesson-content-' + index" role="tabpanel"
               :aria-labelledby="'lesson-tab-' + index">
                <div v-for="(point, pointIndex) in lesson.points" :key="pointIndex" class="max-w-full mb-4">
                    <h3 class="text-lg font-medium text-gray-800">{{ point.name }}</h3>
                    <p class="text-justify text-gray-600" v-html="point.explanation"></p>
                </div>
                <div v-if="lesson.pdf_url != null" class="border-t border-gray-200 flex flex">
                    <a :href="lesson.pdf_url" class="italic text-blue-400 hover:text-blue-700 mr-2">PDF: {{ lesson.name }}</a>
                </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    </PanelLayout>
</template>