import InertiaForm from "@common/components/form/InertiaForm";
import { create } from "@managerRoutes/phys/profile/phones";
import { IPhones } from "./account.types";
import { useManagerRoute } from "@manager/hooks/useAppRoute";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import InputGroup from "@common/components/form/InputGroup";
import Button from "@common/components/form/Button";

interface IProps {
    phones: IPhones[];
}

export default function ({ phones }: IProps) {
    const route = useManagerRoute();

    return (
        <section className="phones">
            <h2>Номера телефонов</h2>
            <InertiaForm {...create.form()} resetOnSuccess={true}>
                {({ errors }) => (
                    <>
                        <InputGroup
                            name='phone'
                            placeholder="7 (###) ###-##-##"
                            error={errors.phone}
                        />
                        <Button className="btn-success" type="submit">Добавить</Button>
                    </>
                )}
            </InertiaForm>
            <div className="phones">
                {phones.map((item, index) => (
                    <InertiaForm
                        key={index}
                        method="delete"
                        action={route(`profile/phones/${item.id}`)}
                        className="item"
                    >
                        <span>{item.phone}</span>
                        <Button type="submit">
                            <FontAwesomeIcon icon={faTrash}/>
                        </Button>
                    </InertiaForm>
                ))}
            </div>
        </section>
    );
}
