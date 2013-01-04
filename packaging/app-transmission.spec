
Name: app-transmission
Epoch: 1
Version: 1.0.0
Release: 1%{dist}
Summary: Transmission
License: GPLv3
Group: ClearOS/Apps
Packager: Tim Burgess
Vendor: Tim Burgess
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
Transmission is a free, lightweight BitTorrent client. It features a simple, intuitive interface on top on an efficient, cross-platform back-end. Transmission has the features you want from a BitTorrent client: encryption, a web interface, peer exchange, magnet links, DHT, uTP, UPnP and NAT-PMP port forwarding, webseed support, watch directories, tracker editing, global and per-torrent speed limits, and more.

%package core
Summary: Transmission - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: transmission >= 2.5
Requires: app-base-core >= 1:1.2.6

%description core
Transmission is a free, lightweight BitTorrent client. It features a simple, intuitive interface on top on an efficient, cross-platform back-end. Transmission has the features you want from a BitTorrent client: encryption, a web interface, peer exchange, magnet links, DHT, uTP, UPnP and NAT-PMP port forwarding, webseed support, watch directories, tracker editing, global and per-torrent speed limits, and more.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/transmission
cp -r * %{buildroot}/usr/clearos/apps/transmission/

install -D -m 0644 packaging/transmission-daemon.php %{buildroot}/var/clearos/base/daemon/transmission-daemon.php

if [ -d %{buildroot}/usr/clearos/apps/transmission/libraries_zendguard ]; then
    rm -rf %{buildroot}/usr/clearos/apps/transmission/libraries
    mv %{buildroot}/usr/clearos/apps/transmission/libraries_zendguard %{buildroot}/usr/clearos/apps/transmission/libraries
fi

%post
logger -p local6.notice -t installer 'app-transmission - installing'

%post core
logger -p local6.notice -t installer 'app-transmission-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/transmission/deploy/install ] && /usr/clearos/apps/transmission/deploy/install
fi

[ -x /usr/clearos/apps/transmission/deploy/upgrade ] && /usr/clearos/apps/transmission/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-transmission - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-transmission-core - uninstalling'
    [ -x /usr/clearos/apps/transmission/deploy/uninstall ] && /usr/clearos/apps/transmission/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/transmission/controllers
/usr/clearos/apps/transmission/htdocs
/usr/clearos/apps/transmission/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/transmission/packaging
%exclude /usr/clearos/apps/transmission/tests
%dir /usr/clearos/apps/transmission
/usr/clearos/apps/transmission/deploy
/usr/clearos/apps/transmission/language
/usr/clearos/apps/transmission/libraries
/var/clearos/base/daemon/transmission-daemon.php
