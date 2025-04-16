import { getNestedValue } from '@/lib/utils'
import { PaginatedResponse } from '@/types'
import type { Column } from '@/types/core/ui-types'
import { Link } from '@inertiajs/react'

interface TableProps<T> {
  data: PaginatedResponse<T>
  columns: Column<T>[]
}

export default function Table<T>({ data, columns }: TableProps<T>) {
  return (
    <>
      <table className='min-w-full divide-y divide-gray-200 border border-gray-300'>
        <thead className='bg-gray-50'>
          <tr>
            {columns.map((column) => (
              <th key={column.accessorKey} className='px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-700 uppercase'>
                {column.header}
              </th>
            ))}
          </tr>
        </thead>
        <tbody className='divide-y divide-gray-200 bg-white'>
          {data.data.map((item, index) => (
            <tr key={index}>
              {columns.map((column) => (
                <td key={column.accessorKey} className='px-6 py-4 whitespace-nowrap'>
                  {'renderCell' in column ? column.renderCell?.(item) : String(getNestedValue(item, column.accessorKey))}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>

      {/* Paginación básica */}
      <div className='mt-4 flex justify-between'>
        <span>
          Página {data.current_page} de {data.last_page}
        </span>
        <div className='space-x-2'>
          {data.prev_page_url && <Link href={data.prev_page_url}>Anterior</Link>}
          {data.next_page_url && <Link href={data.next_page_url}>Siguiente</Link>}
        </div>
      </div>
    </>
  )
}
