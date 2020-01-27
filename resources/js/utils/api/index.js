import axios from 'axios'

export default axios.create({
  baseURL: 'http://accpayable.com/api',
  headers: {
    'Authorization': `Bearer ${localStorage.getItem('token')}`
  }
})
