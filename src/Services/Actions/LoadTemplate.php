<?php

namespace TomatoPHP\FilamentAlerts\Services\Actions;

use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;

trait LoadTemplate
{
    /**
     * @return bool
     * use to load template and replace template tags
     */
    public function loadTemplate(): bool
    {
        /*
         * Get Template By Key
         */
        $this->templateModel = NotificationsTemplate::where('key', $this->template)->first();


        /*
         * Find & Replace Key/Value
         */
        $this->title = str_replace($this->findTitle ?? '', $this->replaceTitle ?? '', $this->templateModel->title);
        $this->message = str_replace($this->findBody ?? '', $this->replaceBody ?? '', $this->templateModel->body);

        /*
         * Set Template URL
         */
        $this->url = $this->templateModel->url;

        /*
         * Set Template Image
         */
        $this->image = count($this->templateModel->getMedia('image')) ? $this->templateModel->getMedia('image')->first()->getUrl() : null;

        /*
         * Set Template Icon
         */
        $this->icon = $this->templateModel->icon;

        /*
         * Set Template Type
         */
        $this->type = $this->templateModel->type;

        if(class_exists(Spatie\Permission\Models\Role::class)){
            /*
           * Check Template For Roles
           */
            $collectRoles = [];
            foreach ($this->templateModel->roles as $role) {
                $collectRoles[] = $role->id;
            }
            if (count($collectRoles)) {
                /*
                 * If Current User Has Role
                 */
                try {
                    if ($this->user->hasRole($collectRoles)) {
                        return true;
                    }
                }catch (\Exception $exception){
                    return false;
                }

                return false;
            }
        }


        return true;
    }
}
