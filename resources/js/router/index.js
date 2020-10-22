import Book from '../../views/book/Book'
import CreateBook from '../../views/book/CreateBook'
export default{

	mode:'history',
	routes:[
		{

			path:'/',
			name:'book',
			component:Book

		},
		{

			path:'/create',
			name:'create',
			component:CreateBook

		},



	]
}