import type { SharedData } from '@/types'
import { Head, Link, usePage } from '@inertiajs/react'

export default function Welcome() {
  const { auth } = usePage<SharedData>().props

  return (
    <>
      <Head title='Welcome'>
        <link rel='preconnect' href='https://fonts.bunny.net' />
        <link href='https://fonts.bunny.net/css?family=instrument-sans:400,500,600' rel='stylesheet' />
      </Head>
      <div className='flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]'>
        <header className='flex w-full max-w-[335px] justify-between text-sm not-has-[nav]:hidden lg:max-w-4xl'>
          <div className='flex flex-shrink-0 items-center'>
            <img className='hidden h-8 w-auto lg:block' src='/img/JoseJesusLogo.jpg' alt='José Jesús' />
            <p className='pl-2 text-xl'>I.E.P José Jesús</p>
          </div>

          <nav className='flex items-center justify-end gap-4'>
            {auth.user ? (
              <Link
                href={route('dashboard')}
                className='inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]'
              >
                Dashboard
              </Link>
            ) : (
              <>
                <Link
                  href={route('login')}
                  className='inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]'
                >
                  Log in
                </Link>
                <Link
                  href={route('register')}
                  className='inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]'
                >
                  Register
                </Link>
              </>
            )}
          </nav>
        </header>
        <div className='flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0'>
          <main className='flex w-full max-w-[335px] flex-col-reverse lg:max-w-4xl lg:flex-row'>
            <div className='gradient'>
              <div className='container mx-auto flex flex-col flex-wrap items-center px-3 py-16 md:flex-row'>
                <div className='flex w-full flex-col items-start justify-center text-center md:w-2/5 md:text-left'>
                  <h1 className='my-4 text-5xl leading-tight font-bold text-gray-800'>Bienvenido al Sistema de Gestión de Tareas</h1>
                  <p className='mb-8 text-2xl leading-normal text-gray-800'>I.E.P JOSE JESUS</p>
                </div>

                <div className='w-full py-6 text-center md:w-3/5'>
                  <img src='img/AdminLTELogo.png' />
                </div>
              </div>
            </div>
          </main>
        </div>
        <div className='hidden h-14.5 lg:block'></div>
      </div>
    </>
  )
}
