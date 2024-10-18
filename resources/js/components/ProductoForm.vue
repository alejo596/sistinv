<template>
  <div class="container-fluid">
    

  <div class="card">
    <div class="card-body">
      <h2 class="card-title mb-4">Registro de Producto</h2>
    <form @submit.prevent="guardarProducto">
        <div class="row g-3">
          <div class="col-md-3">
            <div class="form-floating">
              <select id="tipo_dispositivo" v-model="producto.tipo_dispositivo_id" class="form-select">
                <option v-for="tipo in tiposDispositivos" :key="tipo.id" :value="tipo.id">{{ tipo.nombre }}</option>
              </select>
              <label for="tipo_dispositivo">Tipo de dispositivo</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select id="marca" v-model="producto.marca_id" class="form-select" :required="isRequired('marca_id')">
                <option v-for="marca in marcas" :key="marca.id" :value="marca.id">{{ marca.nombre }}</option>
              </select>
              <label for="marca">Marca</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select id="modelo" v-model="producto.modelo_id" class="form-select" :required="isRequired('modelo_id')">
                <option v-for="modelo in modelos" :key="modelo.id" :value="modelo.id">{{ modelo.nombre }}</option>
              </select>
              <label for="modelo">Modelo</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select id="procesador" v-model="producto.procesador_id" class="form-select" :required="isRequired('procesador_id')">
                <option v-for="procesador in procesadores" :key="procesador.id" :value="procesador.id">{{ procesador.nombre }}</option>
              </select>
              <label for="procesador">Procesador</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select id="ram" v-model="producto.ram_id" class="form-select" :required="isRequired('ram_id')">
                <option v-for="ram in rams" :key="ram.id" :value="ram.id">{{ ram.capacidad }}</option>
              </select>
              <label for="ram">RAM</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select id="almacenamiento" v-model="producto.almacenamiento_id" class="form-select" :required="isRequired('almacenamiento_id')">
                <option v-for="almacenamiento in almacenamientos" :key="almacenamiento.id" :value="almacenamiento.id">{{ almacenamiento.capacidad }}</option>
              </select>
              <label for="almacenamiento">Almacenamiento</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select id="sistema_operativo" v-model="producto.sistema_operativo_id" class="form-select" :required="isRequired('sistema_operativo_id')">
                <option v-for="so in sistemasOperativos" :key="so.id" :value="so.id">{{ so.nombre }}</option>
              </select>
              <label for="sistema_operativo">Sistema operativo</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <input type="text" id="numero_serie" v-model="producto.numero_serie" class="form-control" placeholder="Número de serie" :required="isRequired('numero_serie')">
              <label for="numero_serie">Número de serie</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <input type="text" id="numero_inventario" v-model="producto.numero_inventario" class="form-control" placeholder="Número de inventario" :required="isRequired('numero_inventario')">
              <label for="numero_inventario">Número de inventario</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
            <select id="unidad" v-model="producto.unidad_id" class="form-select" :required="isRequired('unidad_id')">
                <option v-for="unidad in unidads" :key="unidad.id" :value="unidad.id">{{ unidad.nombre }}</option>
              </select>
              <label for="unidad">Unidad</label>
            </div>
          </div>
             <div class="mb-4">
          <label for="product-archivo" class="form-label">Archivo del Producto (CSV)</label>
          <input class="form-control" type="file" id="product-archivo" @change="handleFileUpload" accept=".csv">
        </div>
          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-gradient">Guardar</button>
          </div>
        </div>
      </form>
   
     
    </div>
   
  </div>
  <div class="pt-3">
    <div class="card">
      <div class="card-body">
         <div class="d-flex justify-content-end"> 
         <button @click="procesarFilasSeleccionadas" class="btn btn-success">Procesar seleccionados</button>
       </div>
          <data-table :headers="encabezados" :items="dispositivos"@selection-changed="selectedRows = $event"  />
      </div>
      
    </div>
 
  </div>
  
    </div>
</template>

<script>
  import DataTable from './DataTable.vue';
  import Swal from 'sweetalert2';
export default {
  components: {
    DataTable,
  },
  data() {
    return {
      csvFile: null,
      tiposDispositivos: [],
      marcas: [],
      modelos: [],
      procesadores: [],
      rams: [],
      almacenamientos: [],
      sistemasOperativos: [],
      unidads:[],
      encabezados: [
         { title: 'Id', key: 'id' },
        { title: 'Tipo de dispositivo', key: 'tipo_dispositivo' },
        { title: 'Marca', key: 'marca' },
        { title: 'Modelo', key: 'modelo' },
        { title: 'Procesador', key: 'procesador' },
        { title: 'RAM', key: 'ram' },
        { title: 'Almacenamiento', key: 'almacenamiento' },
        { title: 'Sistema operativo', key: 'sistema_operativo' },
        { title: 'Número de serie', key: 'numero_serie' },
        { title: 'Número de inventario', key: 'numero_inventario' },
        { title: 'Estado', key: 'estados' },
        { title: 'Año', key: 'year' },
         { title: 'Unidad', key: 'unidad' },
      ],
      dispositivos: [],
      searchQuery: '',
      selectedRows: [],
      producto: {
        tipo_dispositivo: '',
        marca: '',
        modelo: '',
        procesador: '',
        ram: '',
        almacenamiento: '',
        sistema_operativo: '',
        numero_serie: '',
        numero_inventario: 0,
      },
    };
  },
  mounted() {
    const fetchData = async () => {
    try {
      const response = await fetch('/api/data'); // Reemplaza con la ruta de tu API
      const data = await response.json();

      this.tiposDispositivos = data.tiposDispositivos;
      this.marcas = data.marcas;
      this.modelos = data.modelos;
      this.procesadores = data.procesadores;
      this.rams = data.rams;
      this.almacenamientos = data.almacenamientos;
      this.sistemasOperativos = data.sistemasOperativos;
      this.unidads=data.unidades;
    } catch (error) {
      console.error('Error al obtener los datos:', error);
    }
  };

  fetchData();
    fetch('/dispositivos')
      .then(response => response.json())
      .then(data => {
        this.dispositivos = data;
      });
  },
  created() { 
    this.getdispositivos();
  },
  methods: {
     handleFileUpload(event) {
      this.csvFile = event.target.files[0];
      alert()
    },
    getdispositivos(){
      fetch('/dispositivos')
      .then(response => response.json())
      .then(data => {
        this.dispositivos = data;
      });
    },
      limpiarFormulario() {
    this.producto = {
      tipo_dispositivo_id: null,
      marca_id: null,
      modelo_id: null,
      procesador_id: null,
      ram_id: null,
      almacenamiento_id: null,
      sistema_operativo_id: null,
      numero_serie: '',
      numero_inventario: ''
    };
  },
   guardarProducto() {
    console.log(this.csvFile)
      if (this.csvFile) {
        this.guardarProductoMasivo();
      } else {
        this.guardarProductoIndividual();
      }
    },

    guardarProductoMasivo() {
      let formData = new FormData();
      formData.append('csv_file', this.csvFile);

      axios.post('/api/productos/masivo', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Los productos se han guardado correctamente.'
        });
        this.limpiarFormulario();
        this.csvFile = null; // Reiniciar el input file
         this.getdispositivos();
      })
      .catch(error => {
        console.error('Error al guardar los productos:', error);
        // Puedes mostrar un SweetAlert de error aquí
      });
    },
    guardarProductoIndividual() {
     
      console.log('Producto a guardar:', this.producto);
     
      axios.post('/api/productos', this.producto)
        .then(response => {
          Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: 'El producto se ha guardado correctamente.'
      });
          this.getdispositivos();
          this.limpiarFormulario();
          
        })
        .catch(error => {
          console.error('Error al guardar el producto:', error);
             Swal.fire({
        icon: 'error',
        title: 'Atencion',
        text: error.response.data.message
      });
        });
    },
    isRequired(field) {
      if(!this.csvFile){


      if (this.producto.tipo_dispositivo_id == 3) {
        return ['marca_id', 'modelo_id', 'numero_serie', 'numero_inventario'].includes(field);
      } else {
        return true; // Todos los campos son requeridos si el tipo de dispositivo es 1 o 2
      }
    }
  },
  procesarFilasSeleccionadas() {
      // ... procesar la información de las filas seleccionadas (this.selectedRows)
      console.log(this.selectedRows);
    }
  },
};
</script>

<style scoped>


@keyframes glowing {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.btn-gradient {
  background: linear-gradient(to right, #667eea, #764ba2);
  border: none;
  color: white;
  padding: 0.75rem 2rem;
  font-weight: bold;
  letter-spacing: 1px;
  transition: all 0.3s ease;
}

.btn-gradient:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}
</style>