<?php

namespace BrngyWiFi\Providers;

use BrngyWiFi\Modules\ActionTaken\Repository\ActionTakenRepositoryInterface;
use BrngyWiFi\Modules\ActionTaken\Repository\EloquentActionTakenRepository;
use BrngyWiFi\Modules\Caution\Repository\CautionRepositoryInterface;
use BrngyWiFi\Modules\Caution\Repository\EloquentCautionRepository;
use BrngyWiFi\Modules\DeviceUser\Repository\DeviceUserRepositoryInterface;
use BrngyWiFi\Modules\DeviceUser\Repository\EloquentDeviceUserRepository;
use BrngyWiFi\Modules\Emergency\Repository\EloquentEmergencyRepository;
use BrngyWiFi\Modules\Emergency\Repository\EmergencyRepositoryInterface;
use BrngyWiFi\Modules\EventGuestList\Repository\EloquentEventGuestListRepository;
use BrngyWiFi\Modules\EventGuestList\Repository\EventGuestListRepositoryInterface;
use BrngyWiFi\Modules\Event\Repository\EloquentEventRepository;
use BrngyWiFi\Modules\Event\Repository\EventRepositoryInterface;
use BrngyWiFi\Modules\GuestList\Repository\EloquentGuestListRepository;
use BrngyWiFi\Modules\GuestList\Repository\GuestListRepositoryInterface;
use BrngyWiFi\Modules\HomeownerAddress\Repository\EloquentHomeownerAddressRepository;
use BrngyWiFi\Modules\HomeownerAddress\Repository\HomeownerAddressRepositoryInterface;
use BrngyWiFi\Modules\Notifications\Repository\EloquentNotificationsRepository;
use BrngyWiFi\Modules\Notifications\Repository\NotificationsRepositoryInterface;
use BrngyWiFi\Modules\RefCategory\Repository\EloquentRefCategoryRepository;
use BrngyWiFi\Modules\RefCategory\Repository\RefCategoryRepositoryInterface;
use BrngyWiFi\Modules\SuggestionComplaints\Repository\EloquentSuggestionComplaintsRepository;
use BrngyWiFi\Modules\SuggestionComplaints\Repository\SuggestionComplaintsRepositoryInterface;
use BrngyWiFi\Modules\UserRoles\Repository\EloquentUserRolesRepository;
use BrngyWiFi\Modules\UserRoles\Repository\UserRolesRepositoryInterface;
use BrngyWiFi\Modules\User\Repository\EloquentUserRepository;
use BrngyWiFi\Modules\User\Repository\UserRepositoryInterface;
use BrngyWiFi\Modules\Visitors\Repository\EloquentVisitorsRepository;
use BrngyWiFi\Modules\Visitors\Repository\VisitorsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventRepositoryInterface::class, EloquentEventRepository::class);
        $this->app->bind(NotificationsRepositoryInterface::class, EloquentNotificationsRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(VisitorsRepositoryInterface::class, EloquentVisitorsRepository::class);
        $this->app->bind(GuestListRepositoryInterface::class, EloquentGuestListRepository::class);
        $this->app->bind(EventGuestListRepositoryInterface::class, EloquentEventGuestListRepository::class);
        $this->app->bind(RefCategoryRepositoryInterface::class, EloquentRefCategoryRepository::class);
        $this->app->bind(EmergencyRepositoryInterface::class, EloquentEmergencyRepository::class);
        $this->app->bind(CautionRepositoryInterface::class, EloquentCautionRepository::class);
        $this->app->bind(DeviceUserRepositoryInterface::class, EloquentDeviceUserRepository::class);
        $this->app->bind(ActionTakenRepositoryInterface::class, EloquentActionTakenRepository::class);
        $this->app->bind(UserRolesRepositoryInterface::class, EloquentUserRolesRepository::class);
        $this->app->bind(HomeownerAddressRepositoryInterface::class, EloquentHomeownerAddressRepository::class);
        $this->app->bind(SuggestionComplaintsRepositoryInterface::class, EloquentSuggestionComplaintsRepository::class);
    }
}
