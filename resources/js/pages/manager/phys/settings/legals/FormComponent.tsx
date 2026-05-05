import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import InputError from "@/components/input-error";
import {Button} from "@/components/ui/button";
import { create } from "@/routes/manager/phys/settings/legals";
import { useForm } from "@inertiajs/react";

export default function() {
    const { data, setData, post, errors, reset } = useForm({
        email: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(create.url(), { onSuccess: () => reset() });
    };

    return (
        <form style={{maxWidth: '550px'}} onSubmit={handleSubmit}>
            <div className="form-group">
                <Label htmlFor="email">E-mail адрес Юр.лица</Label>
                <Input
                    id="email"
                    name="email"
                    type="text"
                    value={data.email}
                    required
                    style={{backgroundColor: '#fff'}}
                    onChange={e => setData('email', e.target.value)}
                />
                <InputError className="error" message={errors.email}/>
            </div>
            <div className="form-group">
                <Button className="btn btn-success" type="submit">Отправить заявку</Button>
            </div>
        </form>
    );
};
