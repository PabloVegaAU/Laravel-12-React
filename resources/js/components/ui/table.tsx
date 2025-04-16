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
    <div className='overflow-x-auto'>
      <table className='dark:border-sidebar min-w-full divide-y divide-gray-200 border border-gray-200 dark:divide-gray-900'>
        <thead className='dark:bg-sidebar bg-gray-50'>
          <tr>
            {columns.map((column) => (
              <th
                key={column.accessorKey}
                className={`px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-300`}
              >
                {column.header}
              </th>
            ))}
          </tr>
        </thead>
        <tbody className='dark:divide-sidebar divide-y divide-gray-200 bg-white dark:bg-black'>
          {data.data.map((item, index) => (
            <tr key={index} className='dark:hover:bg-sidebar transition-colors duration-150 hover:bg-gray-50'>
              {columns.map((column) => (
                <td key={column.accessorKey} className={`px-6 py-4 text-sm whitespace-nowrap text-black dark:text-gray-100`}>
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
    </div>
  )
}
