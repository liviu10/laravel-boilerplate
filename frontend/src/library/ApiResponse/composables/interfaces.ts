import { QTableProps } from 'quasar'

interface ResourceEndpoint {
  id: number
  name: string
  endpoint: string
}

type InputType = 'number' | 'textarea' | 'time' | 'text' | 'password' | 'email' | 'search' | 'tel' | 'file' | 'url' | 'date' | undefined

interface IndexResponse {
  columns?: QTableProps['columns'] | []
  description: string
  filters?: Filter[] | []
  models?: Model[] | []
  results?: object[] | []
  title: string
}

interface Filter {
  field: string
  id: number
  is_active: boolean
  key: string
  name: string
  type: InputType
  value: null
}

interface Model {
  field: string
  id: number
  is_active: boolean
  key: string
  name: string
  type: InputType
  value: null
}

export {
  ResourceEndpoint,
  InputType,
  IndexResponse,
  Filter,
  Model,
}
