       'object_id_str': '${id}',
        'view_data': {
            'pin_id': '${id}',
        },
    },
    require_authentication=True,
    require_explicit_login=True)


r(r'^/m/pin/:id/$',
    pure_react=True,
    is_mobile_fork=True,
    in_mobile_fork_exp=True,
    noindex=True)
