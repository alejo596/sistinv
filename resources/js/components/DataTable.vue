<template>
  <div>
 <input type="text" v-model="searchQuery" placeholder="Buscar...">
   <div class="d-flex justify-content-end"> 
 
  
</div>
<div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
           <th>
            <input type="checkbox" @change="selectAll" v-model="allSelected">
          </th>
          <th v-for="header in headers" :key="header.key">
            {{ header.title }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in filteredItems" :key="index">
           <td>
            <input type="checkbox" v-model="item.selected" @change="updateSelection">
          </td>
          <td v-for="header in headers" :key="header.key">
            {{ item[header.key] }}
          </td>
        </tr>
      </tbody>
    </table>
</div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" href="#" @click.prevent="previousPage">Anterior</a>
        </li>
        <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
          <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" href="#" @click.prevent="nextPage">Siguiente</a>
        </li>
      </ul>
    </nav>
  
  </div>
</template>

<script>
export default {
  props: {
    headers: {
      type: Array,
      required: true,
    },
    items: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      currentPage: 1,
      perPage: 10,
      searchQuery: '',
      allSelected: false,
    };
  },
  computed: {
    // Filtra los elementos según la búsqueda
    filteredItems() {
      if (!this.searchQuery) {
        return this.items;
      }

      const query = this.searchQuery.toLowerCase();
      return this.items.filter(item => {
        return Object.values(item).some(value => {
          return String(value).toLowerCase().includes(query);
        });
      });
    },
    totalPages() {
      return Math.ceil(this.filteredItems.length / this.perPage);
    },
    paginatedItems() {
      const startIndex = (this.currentPage - 1) * this.perPage;
      const endIndex = startIndex + this.perPage;
      return this.filteredItems.slice(startIndex, endIndex);
    },
  },
  methods: {
    goToPage(page) {
      this.currentPage = page;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    selectAll() {
      this.items.forEach(item => {
        item.selected = this.allSelected;
      });
    },
    updateSelection() {
      console.log('selection-changed',this.selectedItems)
      this.updateAllSelected();
      this.$emit('selection-changed', this.selectedItems); // Emitir evento con las filas seleccionadas
    },
    updateAllSelected() {
      this.allSelected = this.items.every(item => item.selected);
    },

  selectedItems() { // Método para obtener las filas seleccionadas
      return this.items.filter(item => item.selected);
    }
  },
};
</script>