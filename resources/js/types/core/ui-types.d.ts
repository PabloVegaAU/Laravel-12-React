export type Column<T> = {
  accessorKey: string
  header: string
  renderCell?: (v: T) => string | React.ReactNode
}
