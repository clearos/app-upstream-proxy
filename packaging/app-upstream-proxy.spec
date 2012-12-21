
Name: app-upstream-proxy
Epoch: 1
Version: 1.4.10
Release: 1%{dist}
Summary: Upstream Proxy
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
The Upstream Proxy app provides a way to connect to upstream proxy servers.

%package core
Summary: Upstream Proxy - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-base >= 1:1.4.7
Requires: app-network-core
Requires: app-events-core

%description core
The Upstream Proxy app provides a way to connect to upstream proxy servers.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/upstream_proxy
cp -r * %{buildroot}/usr/clearos/apps/upstream_proxy/

install -d -m 0755 %{buildroot}/var/clearos/events/upstream_proxy
install -D -m 0644 packaging/filewatch-upstream-proxy-event.conf %{buildroot}/etc/clearsync.d/filewatch-upstream-proxy-event.conf
install -D -m 0600 packaging/upstream_proxy.conf %{buildroot}/etc/clearos/upstream_proxy.conf

%post
logger -p local6.notice -t installer 'app-upstream-proxy - installing'

%post core
logger -p local6.notice -t installer 'app-upstream-proxy-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/upstream_proxy/deploy/install ] && /usr/clearos/apps/upstream_proxy/deploy/install
fi

[ -x /usr/clearos/apps/upstream_proxy/deploy/upgrade ] && /usr/clearos/apps/upstream_proxy/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-upstream-proxy - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-upstream-proxy-core - uninstalling'
    [ -x /usr/clearos/apps/upstream_proxy/deploy/uninstall ] && /usr/clearos/apps/upstream_proxy/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/upstream_proxy/controllers
/usr/clearos/apps/upstream_proxy/htdocs
/usr/clearos/apps/upstream_proxy/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/upstream_proxy/packaging
%exclude /usr/clearos/apps/upstream_proxy/tests
%dir /usr/clearos/apps/upstream_proxy
%dir /var/clearos/events/upstream_proxy
/usr/clearos/apps/upstream_proxy/deploy
/usr/clearos/apps/upstream_proxy/language
/usr/clearos/apps/upstream_proxy/libraries
/etc/clearsync.d/filewatch-upstream-proxy-event.conf
%config(noreplace) /etc/clearos/upstream_proxy.conf
