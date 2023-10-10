import { InputType } from 'src/types/InputType'

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
  IndexResponseInterface,
  ColumnInterface,
  FilterInterface,
  ModelInterface,
}
