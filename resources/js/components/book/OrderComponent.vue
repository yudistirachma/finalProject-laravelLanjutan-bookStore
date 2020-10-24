<template>
	<b-container class="bv-example-row">
  <b-row class="justify-content-md-center">
  
    <b-col cols="12" md="auto">
    	<div  v-for="book in books">
			<div>
			  <b-card
				    title=""
				    img-src="https://picsum.photos/600/300/?image=25"
				    img-alt="Image"
				    img-top
				    tag="article"
				    style="max-width: 20rem;"
				    class="mb-2"
				  >
				    <b-card-text>
				     {{book.description}}
				    </b-card-text>
				    <b-button v-on:click="Order(book)" variant="primary">IDR {{book.price}} .00</b-button>
				  </b-card>
			</div>
		</div>



    </b-col>
    <b-col col lg="4">Table Order  <b-table striped hover :fields="fields" :items="books_order"></b-table>
    	<p>Total Belanjaan :{{total_harga}}</p>
    	<button v-on:click="handlePayButton">Bayar</button>
</b-col>
  </b-row>
</b-container>

</template>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-aZ-g1zLe7E-zMCB0"></script>
<script>
	import BusEvent from '../../bus'
	export default{
		data(){
			return{
				books:[],
				order:[],
				data_midtrans:[],
				book_id:'',
				order_id:'',
				total_harga:0,
				title:'',
				price:'',
				fields: [

					   { key: 'title', label: 'Nama Barang' },
					   { key: 'price', label: 'Harga' },
				],
				books_order:[],
				order:[],
				
				
			}
		},

		mounted(){
			this.get_data()
		},
		methods:{
			get_data:function(){
				axios.get('/api/').then(res => {
					this.books=res.data
					
				}).catch(err => {});
			
			},
			handlePayButton:function(){
				let data={
					'transaction_details':{
						'order_id':this.order_id,
						'id_book':this.book_id,
						'gross_amount':this.total_harga
					}
				};

				axios.post('/api/generate',{data:data}).then(res => {
			//		snap.pay(res.data.data.token)
					snap.pay(res.data.data.token, {
						  onSuccess: function(result){
						    /* You may add your own implementation here */
						    alert("payment success!"); console.log(result);
						  },
						  onPending: function(result){
						    /* You may add your own implementation here */
						    alert("wating your payment!"); console.log(result);
						  },
						  onError: function(result){
						    /* You may add your own implementation here */
						    alert("payment failed!"); console.log(result);
						  },
						  onClose: function(){
						    /* You may add your own implementation here */
						    alert('you closed the popup without finishing the payment');
						  }
						});
					//console.log(res.data.data.token);
				}).catch(err => {});
				// this.$http.post('/api/generate',{data:this.data_midtrans}).then(response=>{
				// 	snap.pay(response.data.data.token)
				// },response=>{
				// 	console.log('error:'+response)
				// });
			},
			Order:function(book){
				this.book_id=book.id
				this.books_order=[

				{
					'title':book.title,
					'price':book.price

				}

				];


				this.belanjaan=[

				{
					'id_book':book.id,
					'amount':book.price,
					'method':'bca'

				}

				];
				this.order.push(this.books_order);
					
				this.total_harga+=book.price;
			
				axios.post('/api/payment/store',{data:this.belanjaan}).then(res => {
						
						this.order_id=res.data.order_id;
						//console.log(this.order_id);
				}).catch(err => {});
				this.order_id=this.order_id;
				console.log(this.order_id);
			}
		}
	}
</script>
<style lang="scss">
	
</style>