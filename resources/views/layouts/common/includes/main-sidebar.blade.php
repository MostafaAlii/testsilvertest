<div class="container-fluid">
    @if(auth('admin')->check())
        @include('layouts.common.includes.sidebar.admin_sidebar')
    @elseif (auth('employee')->check())
        @include('layouts.common.includes.sidebar.employee_sidebar')
    @elseif (auth('company')->check())
        @include('layouts.common.includes.sidebar.company_sidebar')
    @elseif (auth('agent')->check())
        @include('layouts.common.includes.sidebar.agent_sidebar')
    @elseif (auth('call-center')->check())
        @include('layouts.common.includes.sidebar.call-center_sidebar')
    @endif
</div>
