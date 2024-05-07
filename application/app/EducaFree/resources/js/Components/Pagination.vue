<template>
    <div class="m-auto p-4">
      <div class="pagination">
        <span class="text-sm text-gray-700 dark:text-gray-300">
          Showing <span class="font-semibold text-gray-900 dark:text-white ">{{ startEntries }}</span> to <span class="font-semibold text-gray-900 dark:text-white">{{ endEntries }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ totalEntries }}</span> Comments
        </span>
  
        <nav aria-label="Page navigation example" v-if="pagination.next_page_url || pagination.prev_page_url">
          <ul class="inline-flex -space-x-px text-sm">
            <li>
              <a @click.prevent="prevPage"
                 :class="{ 'pointer-events-none': currentPage === 1 || !pagination.prev_page_url }"
                 class="cursor-pointer flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 dark:bg-zinc-600 dark:text-white dark:hover:text-blue-500">
                 <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                </svg>
                    Previous
            </a>
            </li>
            
            <li>
              <a @click.prevent="nextPage"
                 :class="{ 'pointer-events-none': currentPage === totalPages || !pagination.next_page_url }"
                 class="cursor-pointer flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 dark:bg-zinc-600 dark:text-white dark:hover:text-blue-500">
                 Next
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      // Prop que recibe la información de paginación, como el número de página actual, el total de páginas, etc.
      pagination: {
        type: Object,
        required: true
      }
    },
    computed: {
      // Método para obtener el número de página actual
      currentPage() {
        return this.pagination.current_page;
      },
      // Método para obtener el número total de páginas
      totalPages() {
        return this.pagination.last_page;
      },
      // Método para obtener el número de la primera entrada mostrada en la página actual
      startEntries() {
        return (this.pagination.current_page - 1) * this.pagination.per_page + 1;
      },
      // Método para obtener el número de la última entrada mostrada en la página actual
      endEntries() {
        return Math.min(this.pagination.current_page * this.pagination.per_page, this.pagination.total);
      },
      // Método para obtener el número total de entradas
      totalEntries() {
        return this.pagination.total;
      }
    },
    methods: {
      // Método para cambiar a la página anterior
      prevPage() {
        if (this.currentPage > 1) {
          this.changePage(this.currentPage - 1);
        }
      },
      // Método para cambiar a la página siguiente
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.changePage(this.currentPage + 1);
        }
      },
      // Método para cambiar a una página específica
      changePage(pageNumber) {
        this.$emit('pagination-change-page', pageNumber); // Emite un evento al componente padre para que se actualice la información de paginación
      }
    }
  }
  </script>
  