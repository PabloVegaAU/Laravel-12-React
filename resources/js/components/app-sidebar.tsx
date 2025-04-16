import { NavFooter } from '@/components/nav-footer'
import { NavMain } from '@/components/nav-main'
import { NavUser } from '@/components/nav-user'
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar'
import { noTitleNavItems, peopleNavItems, schoolNavItems } from '@/constants'
import type { NavItem } from '@/types'
import { Link } from '@inertiajs/react'
import AppLogo from './app-logo'

const footerNavItems: NavItem[] = []

export function AppSidebar() {
  return (
    <Sidebar collapsible='icon' variant='inset'>
      <SidebarHeader>
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton size='lg' asChild>
              <Link href='/dashboard' prefetch>
                <AppLogo />
              </Link>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarHeader>

      <SidebarContent>
        <NavMain items={noTitleNavItems} />
        <NavMain title='PERSONAS' items={peopleNavItems} />
        <NavMain title='COLEGIO' items={schoolNavItems} />
      </SidebarContent>

      <SidebarFooter>
        <NavFooter items={footerNavItems} className='mt-auto' />
        <NavUser />
      </SidebarFooter>
    </Sidebar>
  )
}
