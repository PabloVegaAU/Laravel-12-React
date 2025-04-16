import type { BreadcrumbItem, SharedData } from '@/types'
import { Transition } from '@headlessui/react'
import { Head, Link, useForm, usePage } from '@inertiajs/react'
import type { FormEventHandler } from 'react'

import DeleteUser from '@/components/delete-user'
import HeadingSmall from '@/components/heading-small'
import InputError from '@/components/input-error'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { useInitials } from '@/hooks/use-initials'
import AppLayout from '@/layouts/app-layout'
import SettingsLayout from '@/layouts/settings/layout'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Profile settings',
    href: '/settings/profile'
  }
]

type ProfileForm = {
  avatar: File | string | undefined
  avatarPreview?: string
  name: string
  email: string
}

export default function Profile({ mustVerifyEmail, status }: { mustVerifyEmail: boolean; status?: string }) {
  const { auth } = usePage<SharedData>().props
  const getInitials = useInitials()

  const { data, setData, setError, errors, post, processing, recentlySuccessful } = useForm<ProfileForm>({
    avatar: auth.user.avatar,
    name: auth.user.name,
    email: auth.user.email,
    avatarPreview: auth.user.avatar
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    post(route('profile.update'), {
      preserveScroll: true
    })
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Profile settings' />

      <SettingsLayout>
        <div className='space-y-6'>
          <HeadingSmall title='Profile information' description='Update your name and email address' />

          <form onSubmit={submit} className='space-y-6'>
            <div className='grid gap-2'>
              <div className='flex items-center gap-2'>
                <Avatar className='size-20 overflow-hidden rounded-full'>
                  <AvatarImage src={data.avatarPreview} alt={auth.user.name} />
                  <AvatarFallback className='rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white'>
                    {getInitials(auth.user.name)}
                  </AvatarFallback>
                </Avatar>
              </div>
              <Input
                id='avatar'
                className='mt-1 block w-full'
                onChange={(e) => {
                  const file = e.target.files?.[0]
                  if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                      setError('avatar', 'The avatar must not be greater than 2MB.')
                      return
                    }
                    const reader = new FileReader()
                    reader.onload = (e) => {
                      setData('avatarPreview', e.target?.result as string)
                    }
                    reader.readAsDataURL(file)
                    setData('avatar', file)
                  }
                }}
                accept='image/png,image/jpeg,image/jpg'
                autoComplete='avatar'
                type='file'
              />

              <InputError className='mt-2' message={errors.avatar} />
            </div>

            <div className='grid gap-2'>
              <Label htmlFor='name'>Name</Label>

              <Input
                id='name'
                className='mt-1 block w-full'
                value={data.name}
                onChange={(e) => setData('name', e.target.value)}
                required
                autoComplete='name'
                placeholder='Full name'
              />

              <InputError className='mt-2' message={errors.name} />
            </div>

            <div className='grid gap-2'>
              <Label htmlFor='email'>Email address</Label>

              <Input
                id='email'
                type='email'
                className='mt-1 block w-full'
                value={data.email}
                onChange={(e) => setData('email', e.target.value)}
                required
                autoComplete='username'
                placeholder='Email address'
              />

              <InputError className='mt-2' message={errors.email} />
            </div>

            {mustVerifyEmail && auth.user.email_verified_at === null && (
              <div>
                <p className='text-muted-foreground -mt-4 text-sm'>
                  Your email address is unverified.{' '}
                  <Link
                    href={route('verification.send')}
                    method='post'
                    as='button'
                    className='text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500'
                  >
                    Click here to resend the verification email.
                  </Link>
                </p>

                {status === 'verification-link-sent' && (
                  <div className='mt-2 text-sm font-medium text-green-600'>A new verification link has been sent to your email address.</div>
                )}
              </div>
            )}

            <div className='flex items-center gap-4'>
              <Button disabled={processing}>Save</Button>

              <Transition
                show={recentlySuccessful}
                enter='transition ease-in-out'
                enterFrom='opacity-0'
                leave='transition ease-in-out'
                leaveTo='opacity-0'
              >
                <p className='text-sm text-neutral-600'>Saved</p>
              </Transition>
            </div>
          </form>
        </div>

        <DeleteUser />
      </SettingsLayout>
    </AppLayout>
  )
}
