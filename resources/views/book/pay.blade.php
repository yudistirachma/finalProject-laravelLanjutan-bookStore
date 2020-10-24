<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div  id="example">
	<button v-on:click="handlePayButton"> Bayar</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-aZ-g1zLe7E-zMCB0"></script>
<script type="text/javascript">
	var vm=new Vue({
		el:'#example',
		data:function(){
			return{
				data_midtrans:{
					'transaction_details':{
						'order_id':'67',
						'id_book':1,
						'gross_amount':200000
					},
					'customer_details':{
						'first_name':'emma',
						'last_name':'asas',
						'email':"asasas@gmail.com",
						'phone':'1212121212121212'
					}
				}
			}
		},
		methods:{
			handlePayButton:function(event){

				this.$http.post('/api/generate',{data:this.data_midtrans}).then(response=>{
					snap.pay(response.data.data.token)
				},response=>{
					console.log('error:'+response)
				});
			}
		}

	})
</script>
</body>
</html>