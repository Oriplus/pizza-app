<template>
  <div class="container bg-body-secondary py-3 vh-100">
    <header class="bg-light mb-3 px-2 rounded">
      <h1 id="title" class="text-center">Pizza Factory<i class="bi bi-list-check"></i></h1>
      <div class="d-flex justify-content-end ">
        <button type="button" class="btn btn-secondary mb-2" @click="openModal('createPizzaModal')">
          Create Pizza
        </button>
      </div>
    </header>
    <section>
      <div>
        <div v-for="pizza in pizzas" :key="pizza.id">
          <div class="shadow px-2 py-1 mb-2 bg-body-tertiary rounded bg-item">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
              <div>
                <span>{{ pizza.name }} - Ingredients: {{ pizza.ingredients.map(i => i.name).join(', ') }} - Price: {{
                  pizza.selling_price }}</span>
              </div>
              <div class="mt-3">
                <button type="button" @click="showEditPizzaModal(pizza)" class="btn btn-primary btn-sm me-2 mb-0">
                  Edit
                </button>
                <button type="button" @click="deletePizza(pizza.id)" class="btn btn-danger btn-sm mb-0">Delete</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal for Creating Pizza -->
    <div class="modal fade" id="createPizzaModal" ref="createPizzaModal" tabindex="-1" aria-labelledby="createPizzaModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createPizzaModalLabel">Create New Pizza</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createPizza">
              <div class="mb-3">
                <label for="pizzaName" class="form-label">Pizza Name</label>
                <input type="text" class="form-control" id="pizzaName" v-model="newPizza.name" required>
              </div>
              <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <div v-for="ingredient in allIngredients" :key="ingredient.id" class="form-check">
                  <input class="form-check-input" type="checkbox" :value="ingredient.id"
                    :id="`ingredient-${ingredient.id}`" v-model="newPizza.selectedIngredients">
                  <label class="form-check-label" :for="`ingredient-${ingredient.id}`">{{ ingredient.name }} - ${{
                    ingredient.cost_price.toFixed(2) }}</label>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Selling Price: ${{ calculateTotalPrice(newPizza.selectedIngredients).toFixed(2)
                }}</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="createPizza">Save Pizza</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Update Pizza -->
    <div class="modal fade" id="updatePizzaModal" ref="updatePizzaModal"  tabindex="-1" aria-labelledby="updatePizzaModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createPizzaModalLabel">{{ editPizza.name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createPizza">
              <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <div v-for="ingredient in allIngredients" :key="ingredient.id" class="form-check">
                  <input class="form-check-input" type="checkbox" :value="ingredient.id"
                    v-model="editPizza.selectedIngredients" :id="`ingredient-${ingredient.id}`">
                  <label class="form-check-label" :for="`ingredient-${ingredient.id}`">
                    {{ ingredient.name }} - ${{ ingredient.cost_price.toFixed(2) }}
                  </label>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Selling Price: ${{ calculateTotalPrice(editPizza.selectedIngredients).toFixed(2)
                }}</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="updatePizza">Save Pizza</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
  data() {
    return {
      pizzas: [],
      allIngredients: [],
      newPizza: {
        name: '',
        selectedIngredients: [],
        sellingPrice: 0
      },
      editPizza: {
        id: null,
        name: '',
        selectedIngredients: [],
        sellingPrice: 0
      }
    };
  },
  created() {
    this.fetchPizzas();
  },
  methods: {
    openModal(modalRef) {
      const modalInstance = new Modal(this.$refs[modalRef]);
      modalInstance.show();
    },
    closeModal(modalRef) {
      const modalInstance = Modal.getInstance(this.$refs[modalRef]);
      if (modalInstance) {
        modalInstance.hide();
      }
    },
    calculateTotalPrice(selectedIngredients) {
      console.log(selectedIngredients)
      const ingredientsCost = selectedIngredients.reduce((total, ingredientId) => {
        const ingredient = this.allIngredients.find(i => i.id === ingredientId);
        return ingredient ? total + ingredient.cost_price : total;
      }, 0);
      const sellingPrice = ingredientsCost + (ingredientsCost * 0.50);
      return sellingPrice;
    },
    fetchPizzas() {
      axios.get('/api/pizzas')
        .then(response => {
          this.pizzas = response.data.pizzas;
          this.allIngredients = response.data.ingredients;
        })
        .catch(error => {
          console.error(error);
        });
    },
    createPizza() {
      axios.post('/api/pizzas', {
        name: this.newPizza.name,
        ingredients: this.newPizza.selectedIngredients,
        selling_price: this.calculateTotalPrice(this.newPizza.selectedIngredients).toFixed(2)
      })
        .then(response => {
          this.pizzas = response.data.pizzas;
          this.newPizza = { name: '', selectedIngredients: [], sellingPrice: 0 };
          this.closeModal('createPizzaModal');
        })
        .catch(error => {
          console.error(error);
        });
    },
    deletePizza(id) {
      axios.delete(`/api/pizzas/${id}`)
        .then(response => {
          this.pizzas = response.data.pizzas;
        })
        .catch(error => {
          console.error(error);
        });
    },
    showEditPizzaModal(pizza) {
      this.editPizza.selectedIngredients = pizza.ingredients.map(ingredient => ingredient.id);
      this.editPizza.sellingPrice = this.calculateTotalPrice(this.editPizza.selectedIngredients);
      this.editPizza.id = pizza.id;
      this.editPizza.name = pizza.name;
      this.openModal('updatePizzaModal');
    },
    updatePizza() {
      console.log(this.editPizza.selectedIngredients)
      axios.put(`/api/pizzas/${this.editPizza.id}`, {
        ingredients: this.editPizza.selectedIngredients,
        selling_price: this.calculateTotalPrice(this.editPizza.selectedIngredients).toFixed(2)
      })
        .then(response => {
          this.pizzas = response.data.pizzas;
          this.closeModal('updatePizzaModal');
        })
        .catch(error => {
          console.error(error);
        });
    },
  }
};
</script>