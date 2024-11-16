<?php

namespace TomatoPHP\FilamentAlerts\Services\Actions;

use Filament\Notifications\Notification;

trait FireEvent
{
    /**
     * @return void
     *              use to fire the event of notifications and send notification to queue
     */
    public function fire(): void
    {
        /*
         * Check privacy of the notification
         */
        if ($this->privacy === 'public') {

            /*
             * If public get all users to send to all
             */
            $users = $this->model::all();

            /*
             * Loop on users
             */
            foreach ($users as $user) {
                /*
                 * Set Global User
                 */
                $this->user = $user;

                /*
                 * Check Current lang
                 */
                if ($this->lang) {
                    app()->setLocale($this->lang);
                }

                /*
                 * Set User Id Global
                 */
                $this->id = $user->id;

                /*
                 * Check if notification has Template
                 */
                if (! empty($this->template)) {
                    $loadTemplate = $this->loadTemplate();
                    /*
                     * Check if template is found
                     */
                    if ($loadTemplate) {
                        /*
                        * Check if notification saved on database
                        */
                        if ($this->database || in_array('database', $this->providers)) {
                            $this->sendToDatabase();
                        }

                        if (in_array('reverb', $this->providers)) {
                            Notification::make($this->id)
                                ->title($this->title)
                                ->body($this->message)
                                ->icon($this->icon)
                                ->color($this->type)
                                ->actions($this->url ? [
                                    \Filament\Notifications\Actions\Action::make('view')
                                        ->label('View')
                                        ->url($this->url)
                                        ->markAsRead(),
                                ] : [])
                                ->broadcast($this->model::find($this->id));
                        }
                        /*
                         * Fire a job
                         */
                        $this->sendToJob();
                    }
                }
                /*
                 * Notification don't have template
                 */
                else {
                    /*
                     * Check if notification saved on database
                     */
                    if ($this->database || in_array('database', $this->providers)) {
                        $this->sendToDatabase();
                    }

                    if (in_array('reverb', $this->providers)) {
                        Notification::make($this->id)
                            ->title($this->title)
                            ->body($this->message)
                            ->icon($this->icon)
                            ->color($this->type)
                            ->actions($this->url ? [
                                \Filament\Notifications\Actions\Action::make('view')
                                    ->label('View')
                                    ->url($this->url)
                                    ->markAsRead(),
                            ] : [])
                            ->broadcast($this->model::find($this->id));
                    }

                    /*
                     * Fire a job
                     */
                    $this->sendToJob();
                }
            }
        } elseif ($this->privacy === 'private') {

            /*
             * Get user to send notification
             */
            $this->user = $this->model::find($this->id);
            /*
             * Check if user exists
             */
            if ($this->user) {
                /*
                 * Check User Lang
                 */
                if ($this->lang) {
                    app()->setLocale($this->lang);
                }

                if (! empty($this->template)) {
                    $loadTemplate = $this->loadTemplate();
                    if ($loadTemplate) {
                        if ($this->database || in_array('database', $this->providers)) {
                            $this->sendToDatabase();
                        }
                        if (in_array('reverb', $this->providers)) {
                            Notification::make($this->id)
                                ->title($this->title)
                                ->body($this->message)
                                ->icon($this->icon)
                                ->color($this->type)
                                ->actions($this->url ? [
                                    \Filament\Notifications\Actions\Action::make('view')
                                        ->label('View')
                                        ->url($this->url)
                                        ->markAsRead(),
                                ] : [])
                                ->broadcast($this->model::find($this->id));
                        }
                        $this->sendToJob();
                    }
                } else {
                    if ($this->database || in_array('database', $this->providers)) {
                        $this->sendToDatabase();
                    }
                    if (in_array('reverb', $this->providers)) {
                        Notification::make($this->id)
                            ->title($this->title)
                            ->body($this->message)
                            ->icon($this->icon)
                            ->color($this->type)
                            ->actions($this->url ? [
                                \Filament\Notifications\Actions\Action::make('view')
                                    ->label('View')
                                    ->url($this->url)
                                    ->markAsRead(),
                            ] : [])
                            ->broadcast($this->model::find($this->id));
                    }
                    $this->sendToJob();
                }
            }
        }
    }
}
