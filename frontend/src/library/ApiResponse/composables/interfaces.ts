interface ResourceEndpointInterface {
  id: number
  name: string
  endpoint: string
}

type InputType = 'number' | 'textarea' | 'time' | 'text' | 'password' | 'email' | 'search' | 'tel' | 'file' | 'url' | 'date' | undefined

interface IndexResponseInterface {
  columns?: ColumnInterface[] | []
  description: string
  filters?: FilterInterface[] | []
  models?: ModelInterface[] | []
  results?: object[] | []
  title: string
}

interface ColumnInterface {
  align: string
  field: string
  headerStyles: string
  id: number
  label: string
  name: string
  style: string
}

interface FilterInterface {
  field: string
  id: number
  is_active: boolean
  key: string
  name: string
  type: InputType
  value: null
}

interface ModelInterface {
  field: string
  id: number
  is_active: boolean
  key: string
  name: string
  type: InputType
  value: null
}

export {
  ResourceEndpointInterface,
  InputType,
  IndexResponseInterface,
  ColumnInterface,
  FilterInterface,
  ModelInterface,
}
